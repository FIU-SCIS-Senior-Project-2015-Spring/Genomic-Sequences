#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <sys/stat.h>

#define LINE_LENGHT 256  // defining the lenght of a line in the data file
#define MAX_LINES 10     // defining the maximum number of lines the bash file can have

FILE *inp1;              // global file pointers to open and close files
FILE *inp2;
FILE *out;


// function to find the genomic probes in the data file
void findProbes(char file1[], char file2[], char fileResult[])
{
	int i = 0;                                          // counters for loops
	int j = 0;
	int file1NumbLines = 0;                             // counts the number of lines in the data file
    int c;                                              // for counting end of line characters

    printf("\nProcessing the files\n");
    inp1 = fopen(file1, "r");                           // opening the file1 to read
    inp2 = fopen(file2, "r");                           // opening the file2 to read
    out  = fopen(fileResult, "w");                      // creating the result file to write to

	for (c = getc(inp1); c != EOF; c = getc(inp1)) {    // extract characters from data file and store in character c
    	if (c == '\n') {                                // increment count if this character is newline
        	file1NumbLines = file1NumbLines + 1;        // count the number of lines
        }
    }
    rewind (inp1);                                      // rewind the file pointer to the beginning
    //printf("number of lines %d\n", file1NumbLines);

    char aProbeLine [LINE_LENGHT];                      // temporaly stores the lines of the data file
    char aBashLine [MAX_LINES] [LINE_LENGHT];    		// permanently stores the lines of the bash file 
    int bashFile [MAX_LINES];                    		// number of times a line from bash file appears in data file
    int lineNumbers [MAX_LINES][file1NumbLines]; 		// stores the line numbers for ocurrences of bashFile and where they are ocurring
    int bashPointer [MAX_LINES];                 		// helps keep track of position lineNumbers to be stored in lineNumbers  
    int count = 0;										// a counter
    
    // getting the lines from bash file and setting all counters to 0
    while ((fgets(aBashLine[count], LINE_LENGHT, inp2) != NULL) && (count < MAX_LINES)) {
    	bashFile[count] = 0;
    	bashPointer[count] = 0;
    	count++;
    }


    if(inp1 && inp2)                      				      // if the open was successful
    {
    	int lines = 0;										  // keep track of number of lines 

		while(fgets(aProbeLine, LINE_LENGHT, inp1) != NULL)   // get a line from data file until the end of the file
		{

            for (i = 0; i < count; i++) {
            	//printf("\nchecking line %d for %s\n", lines, aBashLine[i]);
            	//printf("line in probe file is %s\n", aProbeLine);
                if(strstr (strtok(aProbeLine, "\n"), strtok(aBashLine[i], "\n"))) {  // checking if any of the lines in bash file are contained in the data file
            	    //printf("founded\n");
            	    bashFile[i]++;                                  // keeps track of how many times aaaaa appears in big file or any other element in bash
            	    lineNumbers[i][bashPointer[i]++] = lines + 1;   // keeps track of the lines in where aaaaa or other element in bash appears in big file
            	    break;
            	}
        	}
        	lines++; 
		}
		
 		// at this point the algorithm finished, now we are printing the results to the output file
		fprintf(out, "%-15s%-15s%-15s\n", "Sequence", "times", "lines");
		fprintf(out, "%-15s%-15s%-15s\n", "--------", "-----", "-----");
		for (i = 0; i < count; i++) {
            fprintf(out, "%s%13d", aBashLine[i], bashFile[i]); // number of times the elements of bash appears in data file
            fprintf(out, "%-8s","\t");
            for (j = 0; j < bashPointer[i]; j++) {
            	if( j == 0)
            		fprintf(out, "%2d", lineNumbers[i][j]);  // lines where the elements are appearing in data file
            	else
            		fprintf(out, ",%2d", lineNumbers[i][j]);

            }
            fprintf(out, "\n");
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


// this is the main function where the files are received
int main(int argc, char *argv[])
{ 
    findProbes(argv[1], argv[2], argv[3]);      // calling findProbes and passing the parameters
    return (EXIT_SUCCESS);
}







