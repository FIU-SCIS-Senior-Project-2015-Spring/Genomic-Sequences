#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include <stdbool.h>
#define SIZE 500 //defining the amount of characters to get from the file 

//pointers to open and close the file
FILE *infile;
FILE *out;

// function that is going to determine if the file is type DNA only
bool isDNA(char file[])
{
    int i = 0;
    for(i = 0; i < SIZE; i++) // to be DNA the file needs to contain ACGT bases, otherwise is not DNA
    {
        if(file[i] == 'a' || file[i] == 'g' || file[i] == 'c'  || file[i] == '\n') {
            continue;
        }
        else if (file[i] == 't') {
                return true;
        } 
    }
    return false;
}

// function that is going to determine if the file is type RNA
bool isRNA(char file[])
{
    int i = 0;
    for(i = 0; i < SIZE; i++) // to be RNA the file needs to contain ACGU bases, otherwise is not RNA
    {
        if(file[i] == 'a' || file[i] == 'g' || file[i] == 'c' || file[i] == '\n') {
            continue;
        }
        else if (file[i] == 'u') {
                return true;
        }
    }
    return false;
}

//this is the main function
void analyzeData(char file[], char fileResult[], char fileName[]) 
{    
    char data[SIZE];  // array to hold 500 sample elements from the file
    int i = 0;        // variable to hold the index of the char array

    printf("\nAnalyzing the file: %s\n", fileName);
    infile = fopen(file, "r");        // opening the file1 to read
    out    = fopen(fileResult, "w");  // creating the result file to write to
    
    // if the file cannot be opened correctly print an error message
    if(infile == NULL)
    {
        printf("The file %s cannot be opened!\n", fileName);
        exit(EXIT_FAILURE);
    }
    else                                 // if the file was opened correctly
    {
        for(i = 0; i < SIZE; i++) {      // get 500 characters from the file to be analyzed
            char c = fgetc(infile);      // get a char
            if( feof(infile) )           // if we reach the end of file break
            {
                break ;
            }
            data[i] = c;                 // otherwise populate de data array with the 500 sample chars
        }

        if(isDNA(data)){                  // the following functions test what type of data the file is
            printf("The data type of file %s is DNA\n", fileName);
            fprintf(out, "The data type of file %s is DNA\n", fileName);
        }
        else if(isRNA(data)){
            printf("The data type of file %s is RNA\n", fileName);
            fprintf(out, "The data type of file %s is RNA\n", fileName);
        }
        else{
            printf("The data type of file %s is unknown\n", fileName);
             fprintf(out, "The data type of file %s is unknown\n", fileName);
        }

        fclose(infile); // closing the files 
        fclose(out);    
    }
    
}

// main function
int main(int argc, char *argv[])
{
    analyzeData(argv[1], argv[2], argv[3]);    // calling analyzeData and passing the parameters file and location
    return (EXIT_SUCCESS);
}

// BASES/NUCLEIC ACID codes acceptable for RNA files: AUGC   
// BASES/NUCLEIC ACID codes acceptable for DNA files: ATGC
    





















