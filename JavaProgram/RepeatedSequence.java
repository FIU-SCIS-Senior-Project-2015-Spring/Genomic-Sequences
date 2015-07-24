import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Scanner;
import java.util.zip.DataFormatException;
 
/**
*
* @author yohan
*
*/
public class RepeatedSequence {
    /**
     * returns Map with repeated sequences and the number of repetitions
     *
     * @param f
     *            File with Genomic sequences
     * @return Map<String,Integer>
     * @throws DataFormatException
     */
    private static Map<String, List<Integer>> getGenomeMap(File f) throws DataFormatException {
        // a map
        Map<String, List<Integer>> genomeMap = new HashMap<String, List<Integer>>();
        // check if the file is in the system
        try {
            // scans the input of the file
            @SuppressWarnings("resource")
            Scanner inputFile = new Scanner(f);
            // counter of genome node positions
            int nodenumber = 0;
            // loop geeting next token
            while (inputFile.hasNext()) {
                // store token
                String sequence = inputFile.next();
                nodenumber++;
                // check key is in map
                if (genomeMap.containsKey(sequence)) {
                    // get list asociated to sequence
                    List<Integer> quantityList = genomeMap.get(sequence);
                    // initial position store repeticions
                    int quantity = quantityList.get(0);
                    quantity++;
                    // update repetitions
                    quantityList.set(0, quantity);
                    // add new position founded it
                    quantityList.add(nodenumber);
                    // update sequence info in the map
                    genomeMap.put(sequence, quantityList);
                }
                // initializing new genome sequences
                else {
                    // Creating list for repetions | positions
                    List<Integer> genesis = new ArrayList<Integer>();
                    genesis.add(1);
                    genesis.add(nodenumber);
                    genomeMap.put(sequence, genesis);
                }
            }
        } catch (FileNotFoundException e) {
 
            e.printStackTrace();
        }
        return genomeMap;
    }
 
    /**
     * Defined by 1 parameter which is the file to be analyzed
     *
     * @param args
     */
    public static void main(String[] args) {
        // check for the genome have argument
        if (args.length > 0) {
            String filename = args[0];
            String fileout = args[1];

            File file = new File(filename);
            String newFiileName = file.getName();
            /**
             * OutputStream that writes on the chosen file
             */
            PrintWriter writer = null;
            try {
                File fileoutput = new File(fileout);
                // creates file path
/*
                if (!fileoutput.getParentFile().exists() && !fileoutput.getParentFile().mkdirs()) {
                    throw new IllegalStateException("Parent Folder couldnt be created");
                }
*/
                writer = new PrintWriter(fileoutput, "UTF-8");
                /**
                 * generate the map with genome sequences
                 */
                Map<String, List<Integer>> temp = null;
                try {
                    temp = getGenomeMap(file);
                } catch (DataFormatException e) {
                    System.err.println(e.getMessage());
                }
                Iterator<Entry<String, List<Integer>>> it = temp.entrySet().iterator();
                /**
                 * flag to check repetitions on the file
                 */
                boolean fileRepeated = false;
                while (it.hasNext()) {
                    Map.Entry<String, List<Integer>> node = (Entry<String, List<Integer>>) it.next();
                    List<Integer> valueList = (List<Integer>) node.getValue();
                    // print the repeated ones
                    if (valueList.get(0) > 1) {
                        /**
                         * flag to check at least 1 repetition
                         */
                        fileRepeated = true;
                        StringBuilder output = new StringBuilder();
                        output.append(node.getKey() + ": Repeated " + valueList.get(0));
                        int previous = 0;
                        for (int i = 1; i < valueList.size(); i++) {
                            int current = valueList.get(i);
                            int distance = 0;
                            if (i != 1) {
                                distance = current - previous;
                            }
                            /**
                             * ternary operation define empty distance for first location
                             */
                            output.append((distance == 0 ? "" : (" Distance: " + distance)) + " ---> Locations: " + current);
                            previous = current;
                        }
                        // print the output in a file
                        writer.println(output);
                        System.out.println(output);
                        System.out.println("<br/>");
                    }
                }
 
                /**
                 * Tackle whe there is no repetion at all
                 */
                if(!fileRepeated){
                    String report = "THERE ARE NO GENOME REPETITIONS ON THE FILE";
                    writer.println(report);
                    System.out.println(report);
                    System.out.println("<br/>");
                }
                writer.close();
 
            } catch (FileNotFoundException e) {
                // TODO Auto-generated catch block
                System.err.println(e.getMessage());
		 System.out.println(e.getMessage());
            } catch (UnsupportedEncodingException e) {
                System.err.println(e.getMessage());
	     	 System.out.println(e.getMessage());
            } finally {
                writer.close();
            }
        }
    }
}
