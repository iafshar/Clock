# Clock

## Creating a Clock

A clock is a unique way of visualizing music. It uses a metronome that continuously spins around a circle with one point being fixed in the center. You can then add percussive sounds anywhere in the circle and when the metronome hits them, the sounds are played. The image below demonstrates how it looks. The colors of the buttons will be the same as the colors of the mini circles that represent the sound identified by the text of the button. A red mini circle would represent the sound of a snare, a pink one would represent the sound of a kick, and so on.

<img width="1440" alt="Screenshot 2023-12-23 at 10 25 12 AM" src="https://github.com/iafshar/Clock/assets/102998427/08a1b557-ffd8-423c-8b8e-54e224c366e1">

You can also delete a mini circle from the screen by dragging it and dropping it to the trash icon. Another thing you can do is change the tempo of your clock which would affect the speed at which the metronome spins. You can do this by dragging the slider at the bottom of the screen horizontally, or you can click on the keypad image in the bottom right corner which will take you to the page shown below.

<img width="664" alt="Screenshot 2023-08-24 at 3 56 36 PM" src="https://github.com/iafshar/Clock/assets/102998427/8dd28c93-6e9b-4eac-9d37-bb1dd34fbaad">

Here you can manually set the tempo by clicking on the number keys on the screen or by using the number keys on your keyboard. You can also, periodically click on the button saying "click" and the tempo will be set to the tempo at which you are clicking.

Saving and sharing are features only accessible by account holders. Saving a clock allows only the creator of the clock to view it while sharing a clock allows other account holders to view it. If you click on the "Save" or "Share" buttons, you are prompted to give the clock a name before it will be added to the database and your account. 

This is a social media site built around clocks. It allows you to create different types of accounts, create clocks, and share them with other accounts. In the same vein as Instagram, it allows you to like and comment on other clocks, and follow other accounts, chat with other users, and it also offers a page designed specifically for you to see the most popular clocks.

## Logging in/Signing up

It starts by giving the user 3 options: to log in to their account, to sign up for a new account, or to continue without an account. 

If they choose to continue without an account, they are taken to a clock page similar to the first image but it will not have the "save" or "share" buttons as these are features only available for users with an account. 

If they choose to sign up for a new account, they have the option to choose to sign up for a premium account or a basic account. A basic account allows a user to save and share up to 5 clocks while a premium account allows users to save and share up to 20 clocks, comment on other clocks, and reply to comments. As of now, there is nothing extra that a user needs to do to sign up for a premium account but I intend on implementing a price that users have to pay with a credit card for premium accounts. Account holders at any time can also choose to either downgrade their account to basic or upgrade it to premium. After choosing which account they want to sign up for, the users have to enter a username, password, and email which all go through validation checks. The checks include making sure the username and email are unique, and making sure the password is at least 6 characters long, has at least one letter, at least one number, and at least one special character. If these checks pass, an email with a verification link is sent to the email they entered which they have to click on for them to use the site.

If they choose to log in, they need to enter their account's username and password. There is also an option they can click on if they have forgotten their password, which allows them to enter their email and a verification link is sent to that email if it is attached to a user. The link in their email takes them to a form where they can update their password and log in. They will not be permitted to update their password with one they have used before

After a user logs in or signs up, until they exit the page or log out, there is a navbar constantly present at the top of the screen shown below.

<img width="1439" alt="Screenshot 2023-12-23 at 10 34 59 AM" src="https://github.com/iafshar/Clock/assets/102998427/09613de1-7eff-4d91-848e-2a20badb23d1">

From left to right, these link the users to the previous page, their Feed, Discover page, creating a new clock page which is the first image, Home page, Inbox, and Search page. If the user's mouse hovers over the text saying "Account" on the right, they will be presented with a dropdown menu allowing them to upgrade/downgrade their account, deactivate their account, and logout. The icon corresponding to the page you are on becomes highlighted. I will explain these pages below.

## Home Page

After a user logs in or signs up, they are taken to their Home page which will contain all the clocks they have saved or shared. A user who has previously saved or shared clocks is able to edit any of them on this page where they are taken to the page in the first image with all mini circles in the same positions as they were in the last time the clock was saved or shared. The tempo is also retained. A user can also delete a clock on their Home page or change it from saved to shared or vice-versa. A user can also edit the name of any clock on their home page and even search through their clocks by name.

## Searching

A user can also search for the usernames of other users by clicking the search icon at the top of the screen. Once they click on this, they are presented with their history of searches and they can click on any of them to search for it again. They can also delete specific items from their search history and even clear their search history. They can also type into a search bar and will be presented with usernames that either completely or partially match it. They can then click on any of the results and be taken to the profile page of that user. On that page, they can see the shared clocks of that user and choose to follow or message that user. A user can also search through their clocks by name.

## Feed

A user also has a Feed on which they can see all the shared clocks of the users they follow.

## Discover

A user also has a Discover page, which contains the most popular shared clocks and is the same for every user. For a clock to reach the Discover page, its sum of likes and dislikes should be a minimum of 5 and it is ordered by the ratio of its dislikes to likes. 

## Inbox

A user can also view their inbox which by clicking on the mailbox icon in the navbar. This will take them to a page where they can view all the usernames of the users that they have chatted with. If there are messages from certain users that the user hasn't viewed, their usernames will be displayed in bold. The mailbox icon will always have a number corresponding to how many chats the user has not viewed. The user can then click on one of the usernames to open the chat with that user, which will contain all the messages that the two users have sent each other. The user can send more messages to the other user here and also delete previous messages that they have sent.

## How clocks are displayed

At any point a clock is displayed to a user that is not their own clock (on their Feed, Discover page, or on the profile pages of other users), they can choose to like or dislike it by clicking on a thumbs up or thumbs down icon respectively. They can also choose to send a clock to other users which they can view in their chat. They can also remix a clock which means to start editing a copy of it for them to save as one of their own clocks. Premium users can also choose to leave a comment on the clock. Users can also view all the comments on a clock and when they do, premium users can reply to any of the comments and like and dislike them. Users can also view all the replies to a comment and like and dislike any of the replies. The number of likes and dislikes a clock has and the ability to view the comments of a clock is present every time a user sees a clock (on their Feed, Home page, Discover page, in chats, or on the profile pages of other users). The following image shows how a clock would be displayed on a Feed. This is similar to how they are displayed on a Discover page, in chats, and on the profile pages of other users.

<img width="1436" alt="Screenshot 2023-12-23 at 10 55 51 AM" src="https://github.com/iafshar/Clock/assets/102998427/0fdd4da8-3297-4a6f-b3b6-8b1c1c50b51d">

The name highlighted in bold at the top would be the username of the user who created a clock. A user can click on this to take them to their profile page. Below that is the name of the clock followed by a preview of the clock with its tempo and the time that it was shared. If the user clicks on the preview or on the expand icon, they will be taken to a page like the first image but with the information saved from the last time the creator of the clock shared it. They will not be able to change anything about the clock. If the user clicks on the mute icon, they will be able to hear the sounds of the circles when they are hit by the metronome in the preview. The icon will subsequently change to a volume icon and this process can be reversed. The mailbox icon will allow the user to choose another user to send the clock to, and the icon to the right of it will allow the user to remix the clock.

The following is how clocks are displayed on a user's Home page. 

<img width="1432" alt="Screenshot 2023-12-23 at 10 59 20 AM" src="https://github.com/iafshar/Clock/assets/102998427/e189c244-567e-4bae-aefa-743aa05ecaca">

The text above the preview of the clock will be the name of the clock and if the user clicks on it, it will become a text box that will allow them to change the written text. Once they click out of it or press enter, the name of the clock will be updated to whatever they entered. Below the preview of the clock is the button they can press to change whether it is shared or not. In the example, the clock is shared so the user can click on it to unshare it. Once they do, the text of the button will change to say "Share". This time, if they click on the expand icon or the preview of the clock, it will take them to a page like the first page with the data saved of the clock from last time, and they will be allowed to edit it and save their changes. They will not be prompted to enter a name for the clock since it already has one. The mute, send, and view comments buttons function identically to how they do in the other pages. However, the like and dislike icons are not clickable because a user should not be able to like or dislike their own clock, and below them are the respective values for the number of likes the clock has and the number of dislikes. Clicking on the trash icon will present the user with a prompt asking them if they are sure they want to delete the clock and if they click yes, the clock is deleted.

This uses a MySQL database and currently only runs on localhost for now. I have plans on publicly hosting this after I implement enough features for it to be ready.
