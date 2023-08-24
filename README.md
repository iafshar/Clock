# Clock

## Creating a Clock

A clock is a unique way of visualizing music. It uses a metronome that continuously spins around a circle with one point being fixed in the center. You can then add percussive sounds anywhere in the circle and when the metronome hits them, the sounds are played. The image below demonstrates how it looks. A red mini circle would represent the sound of a snare, a pink one would represent the sound of a kick, and a dark grey one would represent the sound of a hi hat.

<img width="1440" alt="Screenshot 2023-08-24 at 3 51 42 PM" src="https://github.com/iafshar/Clock/assets/102998427/c6929aa2-ca96-45df-88f3-a0f4b464c0cb">

You can also change the tempo of your clock which would affect the speed at which the metronome spins. You can do this by dragging the slider at the bottom of the screen horizontally, or you can click on the keypad image in the top left corner which will take you to the page shown below.

<img width="664" alt="Screenshot 2023-08-24 at 3 56 36 PM" src="https://github.com/iafshar/Clock/assets/102998427/8dd28c93-6e9b-4eac-9d37-bb1dd34fbaad">

Here you can manually set the tempo by clicking on the number keys on the screen or by using the number keys on your keyboard. You can also, periodically click on the button saying "click" and the tempo will be set to the tempo at which you are clicking.

Saving and sharing are features only accessible by account holders. Saving a clock allows only the creator of the clock to view it while sharing a clock allows other people account holders to view it. If you click on the "Save" or "Share" buttons, you are taken to a page where you are prompted to give the clock a name before it will be added to the database and your account. This page is shown below.

<img width="1440" alt="Screenshot 2023-08-24 at 4 38 16 PM" src="https://github.com/iafshar/Clock/assets/102998427/812adfac-a8fa-4cfc-b566-6ec822eb6547">

This is a social media site built around clocks. It allows you to create different types of accounts, create clocks, and share them with other accounts. In the same vein as Instagram, it allows you to like and comment on other clocks, and follow other accounts, and it also offers a page designed specifically for you to see the most popular clocks.

## Logging in/Signing up

It starts by giving the user 3 options: to log in to their account, to sign up for a new account, or to continue without an account. 

If they choose to continue without an account, they are taken to a clock page similar to the first image but it will not have the "save" or "share" buttons as these are features only available for users with an account. 

If they choose to sign up for a new account, they have the option to choose to sign up for a premium account or a basic account. A basic account allows a user to save and share up to 5 clocks while a premium account allows users to save and share up to 20 clocks, comment on other clocks, and reply to comments. As of now, there is nothing extra that a user needs to do to sign up for a premium account but I intend on implementing a price that users have to pay with a credit card for premium accounts. Basic account holders can also choose to upgrade their accounts to premium accounts. After choosing which account they want to sign up for, the users have to enter a username, password, and email which all go through validation checks. The checks include making sure the username and email are unique, and making sure the password is at least 6 characters long, has at least one letter, at least one number, and at least one special character. If these checks pass, an email with a verification link is sent to the email they entered which they have to click on for them to use the site.

If they choose to log in, they need to enter their account's username and password. There is also an option they can click on if they have forgotten their password, which allows them to enter their email and a verification link is sent to that email if it is attached to a user. The link in their email takes them to a form where they can update their password and log in.

After a user logs in or signs up, until they exit the page or log out, there are 5 icons constantly present at the top left of the screen shown below.

<img width="1440" alt="Screenshot 2023-08-24 at 4 49 51 PM" src="https://github.com/iafshar/Clock/assets/102998427/5546f53d-d609-4c28-9a2a-a6b12ad812b8">

From left to right, these link the users to their Feed, Discover page, creating a new clock page which is the first image, Home page, and their search. The icon corresponding to the page you are on becomes highlighted. I will explain these pages below.

## Home Page

After a user logs in or signs up, they are taken to their Home page which will contain all the clocks they have saved or shared. A user who has previously saved or shared clocks is able to edit any of them on this page where they are taken to the page in the first image with all mini circles in the same positions as they were in the last time the clock was saved or shared. The tempo is also retained. A user can also delete a clock on their Home page.

## Searching

A user can also search for the usernames of other users by clicking the search icon at the top of the screen. Once they click on this, they are presented with their history of searches and they can click on any of them to search for it again. They can also type into a search bar and will be presented with usernames that either completely or partially match it. They can then click on any of the results and be taken to the profile page of that user. On that page, they can see the shared clocks of that user and choose to follow that user.

## Feed

A user also has a Feed on which they can see all the shared clocks of the users they follow.

## Discover

A user also has a Discover page, which contains the most popular shared clocks and is the same for every user. For a clock to reach the Discover page, its sum of likes and dislikes should be a minimum of 5 and it is ordered by the ratio of its dislikes to likes. 

## How clocks are displayed

At any point a clock is displayed to a user that is not their own clock (on their Feed, Discover page, or on the profile pages of other users), they can choose to like or dislike it by clicking on a thumbs up or thumbs down icon respectively. They can also choose to leave a comment on the clock. Users can also view all the comments on a clock and when they do, they can reply to any of the comments. Users can also view all the replies to a comment. The number of likes and dislikes a clock has and the ability to view the comments of a clock is present every time a user sees a clock (on their Feed, Home page, Discover page, or on the profile pages of other users). The following image shows how clocks are displayed on a Feed. This is similar to how they are displayed on a Discover page and on the profile pages of other users.

<img width="1440" alt="Screenshot 2023-08-24 at 4 34 00 PM" src="https://github.com/iafshar/Clock/assets/102998427/d49e5b32-4f1b-488a-9df4-f449544e742a">

If a user clicks on "View Clock" they will be taken to a page like the first image but with the information saved from the last time the creator of the clock shared it.

The following is how clocks are displayed on a user's Home page. 

<img width="1440" alt="Screenshot 2023-08-24 at 4 35 35 PM" src="https://github.com/iafshar/Clock/assets/102998427/6d25fa72-c58e-49ec-a8c5-35b2c34648ad">

If they click on "Edit" they will be taken to a page like the first image but with the information saved from the last time they saved or shared it. The icon to the left of "Edit" allows them to delete the clock.



This uses a MySQL database and currently only runs on localhost for now. I have plans on publicly hosting this after I implement enough features for it to be ready.
