#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <sys/stat.h>

#define LINE_LENGHT 256  // defining the lenght of a line in a data file


FILE *inp1;              // global file pointers to open and close files
FILE *inp2;
FILE *out;


// function to find what is contained in file1 that is not in file2 and viceversa
// also store the result in the file result path
void findDifferences(char file1[], char file2[], char fileResult[], char fileOneName[], char fileTwoName[])
{
    printf("\nProcessing the files\n");
    inp1 = fopen(file1, "r");                               // opening the file1 to read
    inp2 = fopen(file2, "r");                               // opening the file2 to read
    out  = fopen(fileResult, "w");                          // creating the result file to write to

    if(inp1 && inp2) {                                      // if both files were opened succesfully, do

        int file1NumbLines = 0;                             // counts the number of lines in file1
        int file2NumbLines = 0;                             // counts the number of lines in file2
        int c;                                              // for counting end of line characters

    	for (c = getc(inp1); c != EOF; c = getc(inp1)) {    // extract characters from file1 and store in character c
        	if (c == '\n') {                                // increment count if this character is newline
            	file1NumbLines = file1NumbLines + 1;        // store the number of lines in file 1
            }
        }
        rewind (inp1);                                      // rewind the file1 pointer to the beginning

        for (c = getc(inp2); c != EOF; c = getc(inp2)) {    // extract characters from file2 and store in character c
            if (c == '\n') {                                // increment count if this character is newline
                file2NumbLines = file2NumbLines + 1;        // store the number of lines in file 2
            }
        }
        rewind (inp2);                                      // rewind the file2 pointer to the beginning
    
        char first_file[file1NumbLines + 1][LINE_LENGHT];   // to store the content of file 1 without repeats
        char second_file[file2NumbLines + 1][LINE_LENGHT];  // to store the content of file 2 without repeats
        char file1_line[LINE_LENGHT];                       // to get file 1 lines
        char file2_line[LINE_LENGHT];                       // to get file 2 lines 
        int file1_count = 0;                                // counters for files
        int file2_count = 0;
        int i = 0;                                          // counter for loops
        int j = 0;
        int a = 0;
        int b = 0;

        // here we are going to store the content of the files but without repeats
        fgets(first_file[file1_count++], LINE_LENGHT, inp1); // getting the first line from file1 and increment to the next position

        while ((fgets(file1_line, LINE_LENGHT, inp1) != NULL) && (file1_count < file1NumbLines + 1)) { // read until end of file 1 and file1_count = file 1 number of lines
            bool found = false;                                // flag to find a repeats
            for(i = 0; i < file1_count; i++) {
                if(strstr (strtok(file1_line, "\n"), strtok(first_file[i], "\n"))) {  // if there is a repeat do nothing
                    found = true;
                    break;
                }
            }
            if(!found)                                         // otherwise store the new value and increment to the next position
                strcpy(first_file[file1_count++], file1_line);
        }
        //for(i = 0; i < file1_count; i++)
            //printf("file 1: %s\n", first_file[i]);

        fgets(second_file[file2_count++], LINE_LENGHT, inp2);  // getting the first line from file2 and increment to the next position

        while ((fgets(file2_line, LINE_LENGHT, inp2) != NULL) && (file2_count < file2NumbLines + 1)) { // read until end of file 2 and file2_count = file 2 number of lines
            bool found = false;                                 // flag to find a repeats
            for(i = 0; i < file2_count; i++) {
                if(strstr (strtok(file2_line, "\n"), strtok(second_file[i], "\n"))) {   // if there is a repeat do nothing
                    found = true;
                    break;
                }
            }
            if(!found)                                          // otherwise store the new value and increment to the next position
                strcpy(second_file[file2_count++], file2_line);
        }
        //printf("\n");
        //for(i = 0; i < file2_count; i++)
            //printf("file 2: %s\n", second_file[i]);


        // here we are going to print the differences between the files
        fprintf(out, "The following are sequences in file %s that are not in file %s:\n\n", fileOneName, fileTwoName);
        fprintf(out, "Sequence\n");
        fprintf(out, "--------\n");
        for(i = 0; i < file1_count; i++) {                       // now we are going to print what is different between file 1 and file 2
            bool match = false;                                  // flag to find a match
            for(j = 0; j < file2_count; j++) {
                if(strstr (strtok(second_file[j], "\n"), strtok(first_file[i], "\n"))) {  // if we find a match update flag and break out
                    match =  true;
                    break;
                }
            }
            if(!match) {                                         // print only the differences between files
                fprintf(out, "%s\n", first_file[i]);
            }
        }

        fprintf(out, "\n\nThe following are sequences in file %s that are not in file %s:\n\n", fileTwoName, fileOneName);
        fprintf(out, "Sequence\n");
        fprintf(out, "--------\n");
        for(a = 0; a < file2_count; a++) {                       // now we are going to print what is similar between file 2 and file 1
            bool match = false;                                  // flag to find a match
            for(b = 0; b < file1_count; b++) {
                if(strstr (strtok(first_file[b], "\n"), strtok(second_file[a], "\n"))) {   // if we find a match update flag and break out
                    match =  true;
                    break;
                }
            }
            if(!match) {                                          // print only the differences between files
                fprintf(out, "%s\n", second_file[a]);
            }
        }

        fclose(inp1);    // closing the files once we finish
        fclose(inp2);
        fclose(out);

    }
    else {               // if an error occurred while opening one of the files display
        printf("Error opening one of the files\n");
        exit(EXIT_FAILURE);
    }

}


// this is the main function where the files are received from PHP
int main(int argc, char *argv[])
{ 
    findDifferences(argv[1], argv[2], argv[3], argv[4], argv[5]);      // calling findDifferences and passing the parameters
    return (EXIT_SUCCESS);
}


