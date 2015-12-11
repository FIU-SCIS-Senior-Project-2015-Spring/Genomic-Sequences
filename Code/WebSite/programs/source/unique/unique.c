#include <stdio.h>
#include <stdlib.h>
#include <string.h>
int main (int argc, char *argv[])
{
	//large string because lines can be very big
    char str[1048576];
    //char str2[1048576];
    //two pointers for the string tokenizer
    char *ptr;
    char *ptr2;
    //file to read from
    FILE *in;
    //FILE *out;
    //to hold location and filename for target filefeedback
    char filename[512];
	//strcpy(filename, argv[2]);    
    //out = fopen(filename,"w+");
	in = fopen(argv[1], "r");
	//read file line by line then extract first and second token from file
    while(fgets(str, sizeof(str),in) != NULL)
    {
    	//strncpy(str2,str,sizeof(str)/sizeof(str[0]));
    	//first token is the actual sub-sequence
    	ptr = strtok(str, " ");
    	//second token is the number of repeats for that sub-sequence
    	ptr2 = strtok(NULL, " ");
    	//if this sub-sequence appears only once, than print it to file 
		if(strcmp(ptr2, "1") == 0)
    		//fprintf(out,"%s = %s\n",ptr,ptr2);
		printf("%s = %s\n",ptr,ptr2);
    }
    //close files
    fclose(in);
    //fclose(out);
    return 0;
 }
