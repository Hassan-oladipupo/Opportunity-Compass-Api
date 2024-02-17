# Opportunity-Compass-Api
The Opportunity Compass API, built with PHP Symfony, serves as a comprehensive platform for managing job opportunities efficiently. This API encompasses a range of functionalities crucial for streamlined job management, including user authentication and authorization, administration of job postings, and job application submission.

Key features of the Opportunity Compass API include:

1. **User Authentication and Authorization**: The API ensures secure access by implementing robust authentication and authorization mechanisms. Users are authenticated through login sessions, which are validated using Redis, providing a seamless and secure user experience.

2. **Job Opportunity Management**: The API facilitates the creation, listing, searching, editing, and deletion of job opportunities. Admin users have exclusive access to these endpoints, allowing them to manage job postings effectively.

3. **Job Application Submission**: Job seekers can utilize the API's endpoint to submit applications for job opportunities seamlessly. Upon submission, the API leverages SendGrid integration to send confirmation emails, enhancing communication between applicants and employers.

4. **Redis-based Session Management**: The API employs Redis to manage user sessions, ensuring secure authentication and authorization processes. User login sessions are maintained for a duration of three hours, enhancing both security and usability.

In summary, the Opportunity Compass API serves as a robust solution for managing job opportunities, providing comprehensive functionality for both administrators and job seekers while prioritizing security, efficiency, and communication.
