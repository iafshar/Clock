# Clock

A clock is a unique way of visualizing music. It uses a metronome that continuously spins around a circle with one point being fixed in the center. You can then add percussive sounds anywhere in the circle and when the metronome hits them, the sounds are played. The image below demonstrates how it looks. A red mini circle would represent the sound of a snare, a pink one would represent the sound of a kick, and a dark grey one would represent the sound of a hi hat.

<img width="1440" alt="Screenshot 2023-08-24 at 3 51 42 PM" src="https://github.com/iafshar/Clock/assets/102998427/c6929aa2-ca96-45df-88f3-a0f4b464c0cb">

Saving and sharing are features only accessible by account holders. Saving a clock allows only the creator of the clock to view it while sharing a clock allows other people account holders to view it. You can also change the tempo of your clock which would affect the speed at which the metronome spins. You can do this by dragging the slider at the bottom of the screen horizontally, or you can click on the keypad image in the top left corner which will take you to the page shown below.

<img width="664" alt="Screenshot 2023-08-24 at 3 56 36 PM" src="https://github.com/iafshar/Clock/assets/102998427/8dd28c93-6e9b-4eac-9d37-bb1dd34fbaad">

Here you can manually set the tempo by clicking on the number keys on the screen or by using the number keys on your keyboard. You can also, periodically click on the button saying "click" and the tempo will be set to the tempo at which you are clicking.


This is a social media site built around clocks. It allows you to create different types of accounts, create clocks and share them with other accounts. In the same vein as Instagram, it allows you to like and comment on other clocks, and follow other accounts, and it also offers a page designed specifically for you to see the most popular clocks.

It starts by giving the user 3 options: to log in to their account, to sign up for a new account, or to continue without an account. 

If they choose to continue without an account, they are taken to a clock page similar to the first image but it will not have the "save" or "share" buttons as these are features only available for users with an account. 

If they choose to sign up for a new account, they have the option to choose to sign up for a premium account or a basic account. A basic account allows a user to save and share up to 5 clocks while a premium account allows users to save and share up to 20 clocks, comment on other clocks, and reply to comments. As of now, there is nothing extra that a user needs to do to sign up for a premium account but I intend on implementing a price that users have to pay with a credit card for premium accounts. They that have to enter a username, password, and email which all go through validation checks. The checks include making sure the username and email are unique, and making sure the password is at least 6 characters long, has at least one letter, at least one number, and at least one special character. If these checks pass, an email with a verification link is sent to the email they entered which they have to click on for them to use the site.

If they choose to log in, they need to enter their account's username and password. There is also an option they can click on if they have forgotten their password, which allows them to enter their email and a verification link is sent to that email if it is attached to a user. The link in their email takes them to a form where they can update their password and log in.

After a user logs in or signs up, they are taken to their home page which will contain all the clocks they have saved or shared. A user who has previously saved or shared clocks is able to edit any of them on this page where they are taken to the page in the first image with all mini circles in the same positions as they were in the last time the clock was saved or shared. The tempo is also retained. A user can also delete a clock on their home page.


This uses a MySQL database and currently only runs on localhost.
