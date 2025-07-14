#include<stdio.h>
#include<string.h>
#include<time.h>
#include<stdlib.h>
#define SIZE 10

struct Visitor{
    int visitorID;
    char name[20];
    int age;
    int gender;
    char entryTime[10];
    char exitTime[10];
    char rideStat[10];
    struct Visitor *next;
};
typedef struct Visitor *visitor;
visitor newVisitor;
visitor first=NULL;
visitor temp=NULL;
int count=0;	//for visitor ID

struct queue{
    int front;
    int rear;
    int que[SIZE];
};

struct rides{
	int rideCode;
	char rideName[20];
	int rideCapacity;
	int noOfRider;
	int max;
	struct queue rideQueue;
	struct queue waitQueue;

}ride[2];

void rideInitiatization();					//for imitializing ride information
void addVisitor();							//for adding visitors
void getVisitorInfo(visitor newVisitor);	//for getting visitor's information
void exitTime();							//for getting exit time of visitors
char* findTime();							//for finding current time
void aboutDisplay();						//Display Options
void displayRides();						//for displaying ride information
void displayAll();							//for displaying visitor information
void displayStaff();						//for displaying staff information
void waitingQueue(int index, int riderID);	//for wait queue
void waitToRide(int index);					//for updating rider queue from wait queue
void riderQueue(int index, int riderID);	//for ride queue
void riderOut(int index);					//for managing visitors out the rider queue
int waitDequeue(int index);					//for wait queue dequeue
int rideDequeue(int index);					//for ride queue dequeue
void displayQueue(int index);				//for managing display of queue information
void displayQueueInfo(int QID);				//for displaying queue information

void main(){
	rideInitiatization();
    struct Visitor visitor;
    int ch;
    char choose;
    do{
    	printf("\n\n\n\tMAIN MENU");
    	printf("\n------------------------------------------------\n");
        printf("\n\t1. Add visitor\n\t2. Visitor Exit\n\t3. Display OPtions\n");
		printf("\t4. Rider TimeUp(BumperCars)\n\t5. Rider TimeUp(RollerCoaster)\n\t6. Exit");
        printf("\nEnter your choice:");
        scanf("%d",&ch);
    switch(ch){
        case 1:
        	addVisitor();
        	break;
        case 2:
        	exitTime();
        	break;
        case 3:
        	aboutDisplay();
        	break;
        case 4:
        	riderOut(0);
        	break;
		case 5:
        	riderOut(1);
        	break;      
        case 6:
        	exit(0);
        default:
        	printf("Invalid Choice.");
    }
    fflush(stdin);
	}while (1);
}

void aboutDisplay(){
	int ch;
	printf("\n\t1. Display Visitors\n\t2. Display Rides\n\t3. Display Staffs\n\t");
	printf("4. Display RideQueue of BumperCars\n\t");
	printf("5. Display RideQueue of RollerCoaster\n\t6. Exit");
    printf("\nEnter your choice:");
    scanf("%d",&ch);
	switch(ch){
		case 1:
        	displayAll();
        	break;       
        case 2:
        	displayRides();
        	break;        
        case 3:
        	displayStaff();
        	break;
        case 4:
        	displayQueue(0);
        	break;
        case 5:
        	displayQueue(1);
        	break;      
        default:
        	printf("Invalid Choice");
	}
}

void rideInitiatization(){
	ride[0].rideCode=110;
	strcpy(ride[0].rideName,"BumperCars");
	ride[0].rideCapacity=2;
	ride[0].noOfRider=0;
	ride[0].max=0;// to manage people in ride queue
	ride[0].waitQueue.front=-1;
	ride[0].waitQueue.rear= -1;
	ride[0].rideQueue.front=-1;
	ride[0].rideQueue.rear= -1;
	
	ride[1].rideCode=111;
	strcpy(ride[1].rideName,"RollerCoster");
	ride[1].rideCapacity=1;
	ride[1].noOfRider=0;
	ride[1].max=0;// to manage people in ride queue
	ride[1].waitQueue.front=-1;
	ride[1].waitQueue.rear= -1;
	ride[1].rideQueue.front=-1;
	ride[1].rideQueue.rear= -1;
}

void displayRides(){
	int i;
	printf("\n**************************************");
	printf("*****************************************\n");
	printf("RideCode\tRideName\tRideCapacity\tNoOfRiders\n");
	printf("\n___________________________________________");
	printf("____________________________________\n");
	for(i=0; i<2; i++){
		printf("%d\t\t%s\t\t%d\t\t%d\n",ride[i].rideCode, 
		ride[i].rideName, ride[i].rideCapacity, ride[i].noOfRider);
	}
	printf("\n***************************************");
	printf("****************************************\n");
}

void addVisitor(){//Add node inn list in the last
    newVisitor=(visitor)malloc(sizeof(struct Visitor));
    if (newVisitor == NULL) {
        printf("Memory allocation failed\n");
        return;
    }
    getVisitorInfo(newVisitor);

    if(first==NULL){
        newVisitor->next=NULL;
        first=newVisitor;
    }
    else{
    	temp=first;
    	while(temp->next!=NULL){
    		temp=temp->next;
		}
        newVisitor->next=NULL;
        temp->next=newVisitor;
    }
    char want;
    int which;
    printf("Do you want to ride?(Y/N)");
    scanf(" %c", &want);
    if(want=='y' || want=='Y'){
    	if(newVisitor->age>=13){
    		printf("\n\t1. Bumper Cars\n\t2. RollerCoaster\nEnter your choice:");
    		scanf("%d", &which);
    		switch(which){
    			case 1:
    				waitingQueue(0, newVisitor->visitorID);
    				break;
    				
    			case 2:
    				waitingQueue(1, newVisitor->visitorID);
    				break;
    				
    			default:
    				printf("No ride selected.");
			}
		}
		else{
			printf("Sorry, Age must be 13 or over.");
		}
	}
}

void getVisitorInfo(visitor newVisitor){
	char* entry;
    newVisitor->visitorID=count+1;
    strcpy(newVisitor->rideStat,"-");
    printf("\nVisitor's Information:\n");
    printf("Name:\t\t");
    gets(newVisitor->name);
    gets(newVisitor->name);
    printf("Age:\t\t");
    scanf("%d", &newVisitor->age);
    printf("Gender(M/F):\t");
    scanf(" %c", &newVisitor->gender);
    entry=findTime();
    strcpy(newVisitor->entryTime, entry);
    newVisitor->entryTime[sizeof(newVisitor->entryTime) - 1] = '\0'; // Ensure null-termination
    strcpy(newVisitor->exitTime, "NULL	");
    count++;
    
}

void exitTime(){
	char* exit;
    int id, exists=0;
    if(first==NULL){
        printf("List is already NULL");
        return;
    }
    printf("Exit time of which id:");
    scanf("%d", &id);
    visitor temp=first;
    while(temp!=NULL){
        if(temp->visitorID==id){
            exit=findTime();
    		strcpy(temp->exitTime, exit);
            temp->exitTime[sizeof(temp->exitTime) - 1] = '\0'; // Ensure null-termination
            exists++;
        }
        temp=temp->next;
    }
    if(exists==0){
    	printf("\nID no.%d not available", id);
	}
    else{
    	printf("\nID no.%d exited.", id);
	}
}

char* findTime(){
    time_t t = time(NULL);
    struct tm *result=localtime(&t);
    static char timeString[20];//for hour, minute, second and null character
    strftime(timeString, 20, "%H:%M:%S", result);
    return (timeString);
}

void displayAll(){
    int i;
    if(first==NULL){
        printf("No data to show.");
        return;
    }
    else{
        visitor temp=first;
        printf("\n***************************************************************************************\n");
        printf("\nID\tName\t\t\tAge\tGender\tEntryTime\tExitTime\tStatus");
        printf("\n________________________________________________________________________________________\n");
        while(temp!=NULL){
            printf("\n%d",temp->visitorID);
            printf("\t%s\t",temp->name);
            printf("\t%d",temp->age);
            printf("\t%c",temp->gender);
            printf("\t%s",temp->entryTime);
            printf("\t%s",temp->exitTime);
            printf("\t%s",temp->rideStat);
            temp=temp->next;
        }
        printf("\n***************************************************************************************\n");
    }
}

void displayStaff(){
	printf("\n*******************************************************************************\n");
	printf("StaffID\t\tStaff Name\tPost\t\t\tPhone no.");
	printf("\n_______________________________________________________________________________\n");
	printf("\n1\t\tFalco Dray\tCEO\t\t\t9800000000");
	printf("\n2\t\tNiobe Hartwall\tManager\t\t\t9800000001");
	printf("\n3\t\tLazar Megara\tAssistant Manager\t9811000000");
	printf("\n4\t\tFreya Sayay\tFinance Manager\t\t9800222222");
	printf("\n5\t\tBrayo Salami\tOffice Manager\t\t9889800000");
	printf("\n*******************************************************************************\n");
}


void riderOut(int index) {
    char ans;
    int dequeued;
    struct queue *q = &ride[index].rideQueue;
    if (q->front == -1) {
        printf("\nQueue is Empty");
        return;
    }
    printf("\nIs the ride's time up? (Y/N): ");
    scanf(" %c", &ans);
    if ((ans == 'Y' || ans == 'y') && q->front != -1) {
        dequeued = rideDequeue(index);
        printf("%d left ride.\n", dequeued);
        temp = first;
        while (temp != NULL) {
            if (temp->visitorID == dequeued) {
                strcpy(temp->rideStat, "-");
            }
            temp = temp->next;
        }
        ride[index].noOfRider--;
        ride[index].max--;
    }
    waitToRide(index);
}

void riderQueue(int index, int riderID) {
    struct queue *q = &ride[index].rideQueue;

    if ((q->rear + 1) % SIZE == q->front) {
        printf("\nQueue is Full");
        return;
    } else if (q->front == -1) {
        q->front = q->rear = 0;
    } else {
        q->rear = (q->rear + 1) % SIZE;
    }
    q->que[q->rear] = riderID;
    visitor temp = first;
    while (temp != NULL) {
        if (temp->visitorID == riderID) {
            strcpy(temp->rideStat, "riding");
        }
        temp = temp->next;
    }
    ride[index].noOfRider++;
    ride[index].max++;
}

void waitingQueue(int index, int riderID) {
    struct queue *w = &ride[index].waitQueue;
    if ((w->rear + 1) % SIZE == w->front) {
        printf("\nQueue is Full");
        return;
    } else if (w->front == -1) {
        w->front = w->rear = 0;
    } else {
        w->rear = (w->rear + 1) % SIZE;
    }
    w->que[w->rear] = riderID;
    waitToRide(index);
}

void waitToRide(int index) {
    struct queue *w = &ride[index].waitQueue;
    int deqID;
    while (ride[index].max < ride[index].rideCapacity && w->front != -1) {
        deqID = waitDequeue(index);
        if (deqID != -1) {
            riderQueue(index, deqID);
        }
    }
}

int waitDequeue(int index) {
    struct queue *q = &ride[index].waitQueue;
    int removedItem;
    if (q->front == -1) {
        printf("\nQueue is Empty");
        return 0;
    }
    removedItem = q->que[q->front];
    if (q->front == q->rear) {
        q->front = q->rear = -1;
    } else {
        q->front = (q->front + 1) % SIZE;
    }
    return removedItem;
}

int rideDequeue(int index) {
    struct queue *q = &ride[index].rideQueue;
    int removedItem;
    if (q->front == -1) {
        printf("\nQueue is Empty");
        return 0;
    }
    removedItem = q->que[q->front];
    if (q->front == q->rear) {
        q->front = q->rear = -1;
    } else {
        q->front = (q->front + 1) % SIZE;
    }
    return removedItem;
}

void displayQueue(int index){
    struct queue *q= &ride[index].rideQueue;
    int i;
    if(q->front==-1){
        printf("Queue is Empty");
        return;
    }
    else{
    int i = q->front;
    printf("\n***************************************************************************************\n");
    printf("ID\tName\t\tAge\tGender\tEntryTime\tExitTime\tRiding Stat");
        while (i != q->rear) {
            displayQueueInfo(q->que[i]);
            i = (i + 1) % SIZE;
        }
    displayQueueInfo(q->que[i]);
    printf("\n***************************************************************************************\n");
    }
}

void displayQueueInfo(int QID){
    visitor temp=first;
    while(temp!=NULL){
        if(QID==temp->visitorID){
            printf("\n%d",temp->visitorID);
            printf("\t%s",temp->name);
            printf("\t%d",temp->age);
            printf("\t%c",temp->gender);
            printf("\t%s",temp->entryTime);
            printf("\t%s",temp->exitTime);
            printf("\t%s",temp->rideStat);
        }
        temp=temp->next;
    }
}
