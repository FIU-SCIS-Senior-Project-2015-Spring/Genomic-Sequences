#include "validate.h"
 
/* This function checks whether a file is empty
 * returns true for empty file or false is file is not empty
 */
bool isEmpty(FILE *file)
{
    long letsCheck = ftell(file);
    fseek(file, 0, SEEK_END);

    if (ftell(file) == 0)
    {
        return true;
    }

    fseek(file, letsCheck, SEEK_SET);
    return false;
}

/* This funcion checks the presence of myChar and
 * and sets its correspondent index to true if it is present
 */ 
int result(char myChar)
{
	switch(myChar)
	{		
		case 'A': checkFile[0] = true; singleCounter[0]++; break;
		case 'B': checkFile[1] = true; singleCounter[1]++; break;
		case 'C': checkFile[2] = true; singleCounter[2]++; break;
		case 'D': checkFile[3] = true; singleCounter[3]++; break;
		case 'E': checkFile[4] = true; singleCounter[4]++; break;
		case 'F': checkFile[5] = true; singleCounter[5]++; break;
		case 'G': checkFile[6] = true; singleCounter[6]++; break;
		case 'H': checkFile[7] = true; singleCounter[7]++; break;
		case 'I': checkFile[8] = true; singleCounter[8]++; break;
		case 'K': checkFile[9] = true; singleCounter[9]++; break;
		case 'L': checkFile[10] = true; singleCounter[10]++; break;
		case 'M': checkFile[11] = true; singleCounter[11]++; break;
		case 'N': checkFile[12] = true; singleCounter[12]++; break;
		case 'P': checkFile[13] = true; singleCounter[13]++; break;
		case 'Q': checkFile[14] = true; singleCounter[14]++; break;
		case 'R': checkFile[15] = true; singleCounter[15]++; break;
		case 'S': checkFile[16] = true; singleCounter[16]++; break;
		case 'T': checkFile[17] = true; singleCounter[17]++; break;
		case 'U': checkFile[18] = true; singleCounter[18]++; break;
		case 'V': checkFile[19] = true; singleCounter[19]++; break;
		case 'W': checkFile[20] = true; singleCounter[20]++; break;
		case 'X': checkFile[21] = true; singleCounter[21]++; break;
		case 'Y': checkFile[22] = true; singleCounter[22]++; break;
		case 'Z': checkFile[23] = true; singleCounter[23]++; break;
		case 'a': checkFile[24] = true; singleCounter[0]++; break;
		case 'b': checkFile[25] = true; singleCounter[1]++; break;
		case 'c': checkFile[26] = true; singleCounter[2]++; break;
		case 'd': checkFile[27] = true; singleCounter[3]++; break;
		case 'e': checkFile[28] = true; singleCounter[4]++; break;
		case 'f': checkFile[29] = true; singleCounter[5]++; break;
		case 'g': checkFile[30] = true; singleCounter[6]++; break;
		case 'h': checkFile[31] = true; singleCounter[7]++; break;
		case 'i': checkFile[32] = true; singleCounter[8]++; break;
		case 'k': checkFile[33] = true; singleCounter[9]++; break;
		case 'l': checkFile[34] = true; singleCounter[10]++; break;
		case 'm': checkFile[35] = true; singleCounter[11]++; break;
		case 'n': checkFile[36] = true; singleCounter[12]++; break;
		case 'p': checkFile[37] = true; singleCounter[13]++; break;
		case 'q': checkFile[38] = true; singleCounter[14]++; break;
		case 'r': checkFile[39] = true; singleCounter[15]++; break;
		case 's': checkFile[40] = true; singleCounter[16]++; break;
		case 't': checkFile[41] = true; singleCounter[17]++; break;
		case 'u': checkFile[42] = true; singleCounter[18]++; break;
		case 'v': checkFile[43] = true; singleCounter[19]++; break;
		case 'w': checkFile[44] = true; singleCounter[20]++; break;
		case 'x': checkFile[45] = true; singleCounter[21]++; break;
		case 'y': checkFile[46] = true; singleCounter[22]++; break;
		case 'z': checkFile[47] = true; singleCounter[23]++; break;
		default: break;
	}
}

/* This function evaluates the values of singleCounter to get the folowing:
 * Total of characters in the file by summing up the values of each
 * index in the counter array and
 * the Percentage of each character present in the file
 * this function is only called in main if file is good file
 */
 int evaluateSingleCounter()
{
	int sum = 0;
	int i;
	//evaluate the sum of all good characters in the file
	for (i = 0; i < COUNTER_SIZE; i++)
		sum += singleCounter[i];
	//evaluate the singlePercentage of each character in the entire file
	for (i = 0; i < COUNTER_SIZE; i++)
	   	singlePercent[i] = (double)(singleCounter[i]*100)/(double)(sum);
	//printf("singleCounter[0] = 'A' is: %ld and the sum is: %d and its singlePercent is: %.2f\n",singleCounter[0],sum,singlePercent[0]);
	return sum;
}


/* This function evaluates the values of checkFile and fills
 * a bool array of three values to whether it is dna, rna or protein
 */
void truthValues()
{
	//A sanity check in case the file was not empty but only had empty lines
	int i;
	for(i=0; i < sizeof(checkFile); i++)
	{
		//check if at least one index is true
    	if(checkFile[i]) 
        	allFalse = false; 
    }

	//if the file is not full of only empty lines
	if(!allFalse)
		//if file is protein, one of these characters must be present and these indexes set to true
		if(checkFile[4] || checkFile[5] || checkFile[8] ||checkFile[10] ||checkFile[13] ||checkFile[14] || checkFile[21] ||checkFile[23] ||checkFile[28] ||  checkFile[29] || checkFile[32] || checkFile[34] ||checkFile[37] ||checkFile[38] ||checkFile[45] ||checkFile[47])
			array[2] = true;
		//else if file is rna all these characters must not be present and all these indexes set to false
		else if(!checkFile[1] && !checkFile[3] && !checkFile[4] && !checkFile[5] && !checkFile[7] && !checkFile[8] && !checkFile[9] && !checkFile[10] && !checkFile[11] && !checkFile[12] && !checkFile[13] && !checkFile[14] && !checkFile[15] && !checkFile[16] && !checkFile[17] && !checkFile[19] && !checkFile[20] && !checkFile[21] && !checkFile[22] && !checkFile[23] && !checkFile[25] && !checkFile[27] && !checkFile[28] && !checkFile[29] && !checkFile[31] && !checkFile[32] && !checkFile[33] && !checkFile[34] && !checkFile[35] && !checkFile[36] && !checkFile[37] && !checkFile[38] && !checkFile[39] && !checkFile[40] && !checkFile[41] && !checkFile[43] && !checkFile[44] && !checkFile[45] && !checkFile[46] && !checkFile[47])
			array[1] = true;
		//otherwise file must be dna
		else
			array[0] = true;
}

/* This function evaluates corresponing values of array
 * returns 0 if dna; 1 if rna and 2 if protein
 */
int evaluateArray()
{
	//if allFalse = true the file is filled with blank lines only
	if(allFalse)
	{
		printf("2\n");
		return 2;
	}
	int i;
	//print statements are just for testing: 0 = false, 1 = true
	//Should be removed after testing
	/*
	printf("\n");
	for(i = 0; i < sizeof(array); i++)
		printf("array values: %d\n", array[i]);
	*/
	//if file is dna return 3;
	if(array[0])
	{
		printf("3\n");
		return 3;
	}
	//if file if rna return 4;
	else if(array[1])
	{
		printf("4\n");
		return 4;
	}
	//if file is protein return 5;
	else
	{
		printf("5\n");
		return 5;	
	}
}
