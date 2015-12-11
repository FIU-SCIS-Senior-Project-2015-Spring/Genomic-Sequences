#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <stdbool.h>

int main(int argc, char** argv) {
	printf("\n----------\n\n");

	if(argc < 3)
	{
		printf("Usage: %s <file_path> <seq_1> ... <seq_n>\n", argv[0]);
		printf("\n----------\n\n");
		return -1;
	}

	FILE *fp = fopen(argv[1], "r");

	if(!fp) {
		printf("File [ %s ] does not exist!\n", argv[1]);
		printf("\n----------\n\n");
		return -1;
	}
	
	int i;
	int read;
	int count = 0; // total
	int count2 = 0; // found
	bool found;
	size_t buff_siz = 1000;
	int probes[argc - 2];
	char *buffer = (char *)malloc(sizeof(char) * (buff_siz + 1));
	char *token;

	for(i = 0 ; i < argc - 2 ; i++) probes[i] = 0; 	

	printf("Scanned: .\nFound: *\n\n");

	while((read = getline(&buffer, &buff_siz, fp)) != -1)
	{
		found = false;
		count++;
		token = (char *)strtok(buffer, " ");

		for(i = 2 ; i < argc ; i++) {
			if(probes[i - 2] == 0)
			{
				if(strcmp(argv[i], token) == 0) {
					printf("*");
					found = true;
					count2++;
					token = (char *)strtok(NULL, buffer);
					probes[i - 2] = atoi(token);
					break;
				}
			}
		}

		if(!found) printf(".");
	}

	printf("\n\n");

	printf("Searched a total of %d (%d found) sequences:\n\n", count, count2);

	fclose(fp);

	for(i = 2 ; i < argc ; i++) {
		if(probes[i - 2] != 0) printf("[ %s ] found with %d locations.\n", argv[i], probes[i - 2]);
		else printf("[ %s ] was not found.\n", argv[i]);
	} 

	printf("\n----------\n\n");
	
	return 0;
}
