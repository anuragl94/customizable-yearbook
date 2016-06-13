# customizable-yearbook
An year book where everyone can customize CSS of their own page

# Concept

SQL database will contain login credentials. Rest of the data will be stored in folders, with usernames as the respective folder names.


Each student can have their unique url, which can be changed upon request (only DB Admin can do it).


The yearbook will have 2 kinds of views. The 'book' view, where all the students' profiles are shown in a single page, and the 'page' view, with each student will have a separate page, with their username as the url.


Each student can login with their credentials to change the CSS for their own page. The features?

1. Each segment will have closure, like reddit. For example, they will be shown text fields for various page elements like "photo", "quote, "details", "social links". If they edit any CSS, it will be wrapped inside the given ID like this:

    &#35;details {}

2. Any 'important' tags given in the 'customized' CSS will be removed.

3. All this generated CSS will be added to a new file which will be stored in the student's folder. 

#Instructions

* Clone the repository onto your system with suitable permissions.

* Add a new virtualhost that points to the location of the cloned repository.

* Reload apache2.

* Make sure `mod_rewrite` and `mod_headers` modules are enabled.

* You're good to go.
