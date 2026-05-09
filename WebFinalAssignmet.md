# Final Assignment – Group Assignment

## General Guidelines

The Library Management System is a comprehensive software solution designed for efficient library operations. It  
enables administrators to manage user registrations, book entries, and member fines. With features like book  
availability tracking and seamless integration, the system ensures a user-friendly and reliable tool for librarians to  
organize, monitor, and maintain library resources effectively.

1. Group Member Allocation  
• Create group with maximum 6 members.  

2. Library Management System Features:  
• Six features have been given to develop a Library Management System   
• If your group has 6 members, 1 members should need to responsible for an one feature.  

3. Version Control (GitHub):  
• Create a public repository and put the code there.  

4. Contribution Monitoring:  
• Each team member must contribute equally. (I’m checking using your GitHub Commits)  

5. Local Deployment:  
• Run the system on localhost using XAMPP.  
• No need for deploying elsewhere.  

6. Database Management:  
• Use the database that is provided to you (database.sql). Don’t create new databases.  
• Strictly follow the below guidelines to import the database.  

7. Demonstration Video (Zoom):  
• Create a 15-minute (maximum) video demonstrating:  
• Overall system and functionalities (you have to demonstrate all create, update, retrieve,  
delete operations by adding values for the system).  
• Mentioned validations in the each feature should need to demonstrate.     
• GitHub best practices, showcasing each branch.  
• Each member presenting their part, introducing themselves.  
• Open the camera while recording.  

8. Final Submission:  
• Include in the Moodle submission:  
• Complete source code.  
• Demonstration video.  
• Text file with team members (with responsible feature), GitHub repository URL (Make  
the GitHub repository public before sharing the URL).  
• Only one member of the team needs to submit the final assignment to Moodle.  

9. Project Technology Stack:  
• Develop the mini project using HTML, CSS and/ or Bootstrap, PHP, and MySQL.  
• Optional: Use AJAX as per your preference. Ensure adherence to these guidelines for a successful  
completion of the assignment.  

Page 1 of 6

# Feature List

## Feature 1 – Login and User registration

❖ Library staff should be able to register with the system by providing their user ID, firstname,  
lastname, username, password, and email address.  
o Validation: Passwords must be more than 8 digits. Registration will be ignored if the  
password is less than 8 digits. Email and username need to be checked for existing  
registrations before submission, provided email also needs to validate over correct  
format.  
o Validation: The user ID should be created in the 'U<BOOK_ID>' format only (e.g., U001).  
If the user sets another text format as the User ID, that record should not be submitted  
to the system. (Hint: Use Regular Expressions).  

❖ Other features should be inside the admin panel. Access to these features is granted only after  
logging in to the system. (Hint: PHP sessions can be used.)  

❖ User details (user ID, firstname, lastname, username, password, email address) need to be  
updated individually once they are added to the system.  

❖ Each user should log in to the system using their specific username and password registered with  
the system.  

❖ User details need to be deleted and updated individually.  

❖ User records should be visible in a table with columns for user ID, firstname, lastname,  
username, password, and email address.  

❖ User should be able to logout from the system.  

❖ Extra marks (optional) – You can use any hashing technique (SHA128, MD5…) to store passwords.  

## Feature 2 – Books registration

❖ Library staff should be able to register books with specific details:  
o Book ID  
o Book Name  
o Book Category (A dropdown menu should be provided for category selection.)  
▪ Validation: The Book ID should be created in the 'B<BOOK_ID>' format only (e.g.,  
B001). If the user sets another text format as the Book ID, that record should not  
be submitted to the system. (Hint: Use Regular Expressions).  

❖ Library staff should be able to Update each book's details (Book ID, Book Name, Book Category)  
after adding it to the database.  

❖ Library staff should be able to Delete each book record individually.  

❖ Library staff should be able to Display each book record in a table with the following columns:  
o Book ID  
o Book Name  
o Book Category  

## Feature 3 – Book category registration

❖ Library staff should be able to register book categories with specific details:  
o Category ID  
o Category Name  
o Date Modified (system date-time of that instance being submitted to the system).  

❖ Library staff should be able to Update each book category's details (Category ID, Category Name,  
Date Modified) after adding it to the system.  

Page 2 of 6

o Validation: The Category ID should be created in the 'C<CATEGORY_ID>' format only  
(e.g., C001). If the user sets another text format as the Category ID, that record should  
not be submitted to the system. (Hint: Use Regular Expressions)  

❖ Library staff should be able to Delete each book category record individually.  

❖ Library staff should be able to Display each book category record in a table with the following  
columns:  
o Category ID  
o Category Name  
o Date Modified  

## Feature 4 – Library member registration (by library staff)

❖ Library staff should be able to register Library members with the system by providing the  
following details:  
o MemberID  
o Firstname  
o Lastname  
o Birthday  
o Email address  
▪ Validation: Email address validation should ensure that the email is in a valid  
format (e.g., sample@mymail.com). The format of the email must be checked  
before submitting.  
▪ Validation: The Member ID should be created in the 'M<MEMBER_ID>' format  
only (e.g., M001). If the user sets another text format as the Member ID, that  
record should not be submitted to the system. (Hint: Use Regular Expressions)  

❖ Library staff should be able to Update user details (Member ID, Firstname, Lastname, Birthday,  
Email address) individually once they are added to the system.  

❖ Library staff should be able to Delete each library member's details individually.  

❖ Library staff should be able to Display each library member's record in a table with the following  
columns:  
o Member ID  
o Firstname  
o Lastname  
o Birthday  
o Email address  

## Feature 5 – Book Borrow details.

❖ Library staff must be able to add borrow details to the system by providing the following  
information:  
o BorrowID  
o BookID  
o MemberID  
o Borrow status  
o Modified date (system date)  
o Borrow Status Update: If a library member borrows a book, the Borrow status should  
change to "borrowed"; otherwise, it should be set to "available" (use drop-down menu).  
▪ Validation: The Borrow ID should be created in the 'BR<MEMBER_ID>' format  
only (e.g., BR001). If the user sets another text format as the Borrow ID, that  
record should not be submitted to the system. (Hint: Use Regular Expressions)  

Page 3 of 6

▪ Validation: The Book ID should be created in the 'B<BOOK_ID>' format only (e.g.,  
B001). If the user sets another text format as the Book ID, that record should not  
be submitted to the system. (Hint: Use Regular Expressions).  
▪ Validation: The Member ID should be created in the 'M<MEMBER_ID>' format  
only (e.g., M001). If the user sets another text format as the Member ID, that  
record should not be submitted to the system. (Hint: Use Regular Expressions)  

❖ Library staff should be able to Update user borrow book details (Borrow ID, Book, Borrow status,  
Modified date) individually once added to the system.  

❖ Library staff should be able to Delete each borrow book detail individually.  

❖ Library staff should be able to Display each Borrow Book record in a table with the following  
columns:  
o BookID  
o Member who borrowed  
o Book Name  
o Borrow Status  
o Date Modified  

## Feature 6 – Assign Fine for a user.

❖ Library staff should be able to assign fines for a library member by providing the following  
details:  
o FineID  
o MemberID  
o BookID  
o Fine amount in LKR  
o Date modified (system date and time).  

❖ Library staff should be able to Update assigned fines by MemberID, fine amount in LKR, and date  
modified once added to the system.  
o Validation: The fine amount must be within the range of 2 LKR (minimum) to 500 LKR  
(maximum). Amounts outside this range will not be accepted.  

❖ Library staff should be able to Delete each assigned fine detail individually.  

❖ Library staff should be able to Display each "Assign Fine" record in a table with the following  
columns:  
o Fine ID  
o Member ID  
o Member Name  
o Book name related to relevant fine.  
o Fine amount in LKR  
o Date Modified  

Page 4 of 6

Designer view of Database (Import this database.sql file – Use the  
guildline below)

## Guideline for Importing The Database

1. Create a database using phpMyAdmin called ‘library_system’ (IMPORTANT: use exact same  
spellings here for the database name!).  
2. Go inside to that created database.  
3. Go to ‘import’ section and upload the database.sql file that provided to you.  

Page 5 of 6


Page 6 of 6


# Final Evaluation

• Both individual contribution and teamwork will be evaluated. (Individual contribution -70%,  
Team work – 30%)  
Presentation in the demonstration video  
(Assigned part).  
10  
Overall completeness and creativeness of the  
whole web application.  
10  
Implementation of the code (Assigned part). 60  
Feature Integration (Teamwork). 10  
Usage of Version Controlling best practices. 10  

• Copying codes from other groups is strictly prohibited and will result in zero marks.