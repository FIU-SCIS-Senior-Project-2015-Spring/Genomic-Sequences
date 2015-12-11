#include "validate_helper.c"

/* To validate a user's given file and check whether it is
 * DNA, RNA or PROTEIN
 * assumption: file is in fasta or fastq format
 */
int main (int argc, char *argv[])
{
	/*A sanity check to verify if file is in DOS format
	if it is, we convert it to unix format using dos2unix
	with a system call*/
	char buffer[256];
	char buffer2[256];
	char buffer3[256];
	char *isDOS = "with CRLF line terminators";
	//char *isDOS2 ="with no line terminators";
	char *temp = " > tempfile.txt";
	//concatenate a single command for a system call
	snprintf(buffer, sizeof(buffer), "file %s ", argv[1]);
	//append command to char temp so it will output to a file
	strcat(buffer,temp);
	//system call to verify if file contains CRLF line terminators, i.e. is in DOS format
	system(buffer);
	//to open file with output from syscall
	FILE *out;
	out = fopen("tempfile.txt", "rw");
	//get the output from syscall
	while (fgets(buffer2, sizeof(buffer2), out));
	//if file is in DOS format then convert it using dos2unix,
	//otherwise we skip and continue with the program
	if(strstr(buffer2, isDOS) != NULL /*|| strstr(buffer2, isDOS2) != NULL*/)
	{
		snprintf(buffer3, sizeof(buffer3), "dos2unix %s ", argv[1]);
		system(buffer3);
	}
	//close and delete temporay file tempfile
	fclose(out);
	remove("tempfile.txt");
	/*End of file format verification*/
	
	//program starts here
	//delcares a file and opens the file given in the parameter argv[1]
	//resultString = GetStdoutFromCommand(buffer);
	FILE *myFile;
	myFile = fopen(argv[1], "r");
	char buf[512];
	//all possible characters accepted in dna, rna and protein
	//note: dna and rna characters set are subsets or protein characters set
	char* myChar = "ABCDEFGHIKLMNPQRSTUVWXYZabcdefghiklmnpqrstuvwxyz";	
	
	char filename[512];//to hold filename for filefeeback
	strcpy(filename, argv[2]);
	//snprintf(filename, sizeof(buffer), "%svalidator_results.txt ", argv[2]);
	
	//Attempts to open myFile, if cannot be opened, then returns a corresponding error
	if (!myFile)
	{
		perror ("Error opening file");
		return 0;
	}	
	//checks if file is empty returns 2 if it is
	if(isEmpty(myFile))
	{
		out = fopen(filename,"w+");
		fprintf(out,"File name: %s\nType: EMPTY FILE\nKeept in Database: NO\n",argv[1]);
		printf("2\n");
	  	return 2;
	}
	char badChar;//to hold first invalid char
	int line = 0;//to keep track of line numbers
	bool isFasta = false;
	bool isFastq = false;
	//check for the first character in file
	//if '>' is fasta, if '@' is fastq and breaks out of loop
	while (fgets(buf, sizeof(buf), myFile))
	{
		if(buf[0] == '>')
		{
			isFasta = true;
			break;
		}
		else if(buf[0] == '@')
		{
			isFastq = true;
			break;
		}
	}

	//printf("isFastq is %d\n",isFastq);
	//printf("isFasta is %d\n",isFasta); 
	
	//check if is fasta first because '>' can also be in fastq files or none of these types
	if(isFasta || !isFastq)
	{
		//close and reopen file for reading
		fclose(myFile);		
		myFile = fopen(argv[1], "r");
		int loop;
		while((loop = getc(myFile)) != EOF)
		{
			line++;
			if (loop == '>')
			{
			    //if '>' skip until the next line is found
			    do
			    {
			    	loop = getc(myFile);
			    }while (loop != EOF && loop != '\n');
			    /*continue;*/
			}
			else
			{
			    	do
			    	{	//If some different character is found in the sequence line exit
			    		//return 2 if file is not valid
			    		//print statements are just for testing
			    		//allow empty newlines
			    		if(loop != '\n')
			    		{
							if(strchr(myChar, loop) == NULL)
							{
								//if bad file we return 2 and exit program
								badChar = loop;
								//printf("bad char is: %c\n",badChar);
								out = fopen(filename, "w+");
								fprintf(out,"File name: %s\nType: INVALID: bad character at line %d : ' %c '\nKept in database: NO",argv[1],line,badChar);
								printf("2\n");
								fclose(myFile);
								fclose(out);
		  						return 2;
							}
						}
						//set checkFile bool array and incremment letter counter
						result(loop);		
						//if not continue lookig for characters not allowed					
			        	loop = getc(myFile);            	
			    	}while (loop != EOF && loop != '\n');//until end of file
			}
		}
		/*this does not work so well because it does not check when file
		does not have line terminators, so we are not using this loop
		while (fgets(buf, sizeof(buf), myFile) != NULL)
		{
			if (buf[0] != '>')
			{
				for(j = 0; j < strlen(buf)-1; j++)
				{
					result(buf[j]);
					if(strchr(myChar,buf[j]) == NULL)
					{
						printf("2\n");
						//printf("2 in fasta buf is %s\n",buf);
						return 2;
					}
				}
			}
		}
		*/
	}

	//run if is a fastq file
	else if(isFastq)
	{
		//reopen file for reading
		fclose(myFile);
		myFile = fopen(argv[1], "r");
		int j;
		//line = 1;
		while (fgets(buf, sizeof(buf), myFile) != NULL)
		{
			line++;
			if(buf[0] == '@')
			{
				//start of record, this is line 1 but now skip to
				//next line and validate characters in that line
				fgets(buf, sizeof(buf), myFile);
				line++;
				//this is line 2 so validate now
				for(j = 0; j < strlen(buf)-1; j++)
				{
					if(strchr(myChar,buf[j]) == NULL)
					{
						//if bad file we return 2 and exit program
						badChar = buf[j];
						//printf("bad char is: %c\n",badChar);
						out = fopen(filename, "w+");
						fprintf(out,"File name: %s\nType: INVALID: bad character at line %d : ' %c '\nKept in database: NO",argv[1],line,badChar);
						printf("2\n");
						fclose(myFile);
						fclose(out);
						return 2;
					}
					result(buf[j]);
				}
				//skip next two lines (3 and 4) of each record and continue looping
				fgets(buf, sizeof(buf), myFile);
				line++;
				fgets(buf, sizeof(buf), myFile);
				line++;
			}
		}
	}
	/*
	if(isFastq)
		printf("Fastq FILE\n");
	if(isFasta)
		printf("Fasta FILE\n");
		
	printf("\n");
	for(j = 0; j < sizeof(array); j++)
		printf("array values: %d\n", array[j]);
	printf("\n");
	for(j = 0; j < sizeof(checkFile); j++)
		printf("array values: %d\n", checkFile[j]);
	*/
	
	//evaluate truth values of array to determine file type
	truthValues();
	//this is the sum of all good characters in the file
	long int sumOfAllChars = evaluateSingleCounter();
	
	//create a file to store file feed back to user
	out = fopen(filename,"w+");
	fprintf(out,"File name: %s\nType: %s\n",argv[1],(array[0]) ? "DNA" : (array[1]) ? "RNA" : (array[2]) ? "PROTEIN" : "INVALID");
	if(allFalse)
		fprintf(out,"The file is neither DNA, RNA nor PROTEIN\nKept in database: NO");
	else
		fprintf(out,"Kept in database: YES\nTotal number of bases: %ld\n\nBase = Occurrences = Percentage\n\n",sumOfAllChars);
	
	int i;
	//print all bases and its percentage in to a file
	for (i = 0; i < COUNTER_SIZE; i++)
	{
		if(singleCounter[i] > 0)
		{
			fprintf(out,"%c = %ld = ",myChar[i],singleCounter[i]);
	   		if(singlePercent[i] < 0.01)//in this case we need more decimal places
	   			fprintf(out,"%0.8f%%\n",singlePercent[i]);
	   		else
	   			fprintf(out,"%0.2f%%\n",singlePercent[i]);
	   	}  	
	}
	
	//printf("sum is %d\n",result);
	/*
	printf("\n");
	for(j = 0; j < sizeof(array); j++)
		printf("array values: %d\n", array[j]);
	printf("\n");
	*/
	//close myFile	
	fclose(myFile);
	fclose(out);
	//If file is good return correspondent values
	return evaluateArray();
}

