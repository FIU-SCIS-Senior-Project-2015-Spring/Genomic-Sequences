#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <float.h>
#include <math.h>

/*Header functions*/

//global array of truth values to hold presence of characters in file
#define CHECKFILE_ROW_SIZE 48
bool checkFile[CHECKFILE_ROW_SIZE] = {false};

//global letter counters
#define COUNTER_SIZE 24
long int singleCounter[COUNTER_SIZE] = {0};
double singlePercent[COUNTER_SIZE] = {0};

//global variable to check if array is all false
bool allFalse = true;

//checks if a file is empty
bool isEmpty(FILE *file);

//global array to evaluate the truth values of checkFile
char array[3] = {false};

//to fill checkFile as a one row truth table
int result(char myChar);

//to evaluate truth values of checkFile
void truthValues();

//to fill array with corresponding boolean values
int evaluateArray();
