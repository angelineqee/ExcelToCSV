package CAT201_assignment;
 
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Iterator;
import java.nio.file.Files;
 
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.apache.commons.io.FilenameUtils;
 
public class ConvertExcelToCSV {
 
    static ArrayList <String> filePaths = new ArrayList <String>();

    public static void getFilePath() throws Exception {
        java.nio.file.Path dir = Paths.get("CAT201_assignment/uploads");
        Files.walk(dir).forEach(path -> showFile(path.toFile()));
    }

    public static void showFile(File file) {
        
        //for checking purpose
        if (file.isDirectory()) {
            System.out.println("Directory: " + file.getAbsolutePath());
        } else {
            filePaths.add(file.getAbsolutePath());

            System.out.println("File: " + file.getAbsolutePath());
        }
    }

    /**
     * @param args
     */
    public static void main(String[] args) {
        try {
            getFilePath();
        } catch (Exception e1) {
            // TODO Auto-generated catch block
            e1.printStackTrace();
        }
        
        ArrayList <File> inputFile = new ArrayList <File> ();
        ArrayList <File> outputFile =  new ArrayList <File> ();
        ArrayList <FileInputStream> fis = new ArrayList <FileInputStream> ();
        ArrayList <FileOutputStream> fos = new ArrayList <FileOutputStream> ();

        for(int i=0; i<filePaths.size(); i++){
            System.out.println(filePaths.get(i));
            System.out.println(filePaths.size());
            System.out.println(i);
            // Creating a inputFile object with specific file path
            inputFile.add(new File(filePaths.get(i)));
    
            String targetDir = "CAT201_assignment/converted";
            // Creating a outputFile object to write excel data to csv
            outputFile.add(new File(targetDir+"/"+FilenameUtils.removeExtension(inputFile.get(i).getName())+".csv"));
    
            // For storing data into CSV files
            StringBuffer data = new StringBuffer();
    
            try {
                // Creating input stream
                fis.add(new FileInputStream(inputFile.get(i)));
                Workbook workbook = null;
    
                // Get the workbook object for Excel file based on file format
                if (inputFile.get(i).getName().endsWith(".xlsx")) {
                    workbook = new XSSFWorkbook(fis.get(i)); 
                } else if (inputFile.get(i).getName().endsWith(".xls")) {
                    workbook = new HSSFWorkbook(fis.get(i));
                } else {
                    fis.get(i).close();
                    throw new Exception("File not supported!");
                }
    
                // Get first sheet from the workbook
                Sheet sheet = workbook.getSheetAt(0);
    
                // Iterate through each rows from first sheet
                Iterator<Row> rowIterator = sheet.iterator();
    
                while (rowIterator.hasNext()) {
                    Row row = rowIterator.next();
                    // For each row, iterate through each columns
                    Iterator<Cell> cellIterator = row.cellIterator();
                    while (cellIterator.hasNext()) {
    
                        Cell cell = cellIterator.next();
    
                        switch (cell.getCellType()) {
                        case BOOLEAN:
                            data.append(cell.getBooleanCellValue() + ",");
                            break;
    
                        case NUMERIC:
                            data.append(cell.getNumericCellValue() + ",");
                            break;
    
                        case STRING:
                            data.append(cell.getStringCellValue() + ",");
                            break;
    
                        case BLANK:
                            data.append("" + ",");
                            break;
    
                        default:
                            data.append(cell + ",");
                        }
                    }
                    // appending new line after each row
                    data.append('\n');
                }
    
                fos.add(new FileOutputStream(outputFile.get(i)));
                fos.get(i).write(data.toString().getBytes());
                fos.get(i).close();
    
            } catch (Exception e) {
                e.printStackTrace();
            }
    
            System.out.println("Conversion of an Excel file to CSV file is done!");
        }
    }
 
}