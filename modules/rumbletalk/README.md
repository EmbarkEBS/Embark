# RumbleTalk Group Chat for Drupal ^9.2 || ^10

CONTENTS OF THIS FILE
---------------------

 * [Introduction](#introduction)
 * [Requirements](#requirements)
 * [Installation](#installation)
 * [Configuration](#configuration)
 * [Troubleshooting](#troubleshooting)
 * [FAQ](#faq)


INTRODUCTION
------------

The RumbleTalk Group Chat Module enables you to embed a chat in your drupal page using a block.

It is the most customizable HTML5 group chat. A site owner can choose their own chat theme from a variety of ready made themes and even create their own theme. It is the fastest way to add a unique fully functional chatroom to any blog or website.

Live group chat module for Drupal. Integrates an online group chat for members only or a social open chat room on your website or for a live online events.

For assistance, you can email us at support@rumbletalk.com
For more information about RumbleTalk Group Chat, visit us on https://rumbletalk.com/

This module is designed for:
 - Drupal 9.2
 - Drupal 10


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.


CONFIGURATION
-------------

- Configure your RumbleTalk Group Chat settings in `[drupal-url]/rumbletalkChat`, you
  will need to have the proper permissions. The page is only intended for Admin use.


TROUBLESHOOTING
---------------

If you encountered a blank block inside your page, log in at your Drupal page as an Admin and you may check your RumbleTalk Group Chat settings in `[drupal-url]/rumbletalkChat`. Check if your hashcode is exactly as the hash in your Admin Panel (https://cp.rumbletalk.com/login).

If the error occurs, please reach us at our support team. 
You can email our support team at support@rumbletalk.com to provide possible solutions.


FAQ
---

Q: What type of chat is it?

A: RumbleTalk is a group chat for websites. You can have private members chat or create a public "open to the world" chat room. 
It is perfect for communities, live event, social stock trades, online radio shows and much more.
[youtube https://www.youtube.com/watch?v=M2h8UyjzuJU]

Q: What about private chat?

A: When you enter a chat room, you can talk in the "lobby" so all will see, or conduct a private one on one chat. Note, you can limit private chat for admins only.

Q: What is the difference between "group chat", "moderated chat" and "experts chat"?

A:  We have several chat types, you can set it up and change it at any time. The next 3 options are:
    1) Group chat - A chat rooms where everyone can talk in the lobby or in private. Moderation is done when a user misbehaving (ban, delete, disconnect).
    2) Moderated chat - A chat room where every message needs to be approved by the admin before it shows to all participants, this is perfect for live events.
    3) Experts chat - this is for Experts (admin), that can talk in multiple private only chat with chat participants.  

Q: Can I talk in video and audio with others in the chat?

A: Sure, you can have private audio and video calls. It works on all PC's laptops and also on mobile devices.

Q: I need only members to access the chat room, can I set it that way?

A: Sure. If you have a members-only site and you only want members to enter/view the chat room. 
You can simply set the chat to be members only. This is super simple, one checkbox to click. Check the member's checkbox, save and you are done.

Q: I see "This chat-room is for private users only" what can I do?

A: This message indicates that the chat accepts only "Drupal users", meaning users that are already logged in to your Drupal site.
    1) If you do not want that, uncheck the "members" checkbox in your plugin.
    2) If the members checkbox is checked and you actually need only members to login to your chat, you will need to check the GUEST login option in the chat settings.
    This does not mean guests will be able to log in, but it will activate a background module that is needed for the Auto-login option.


Q: I need a public chat room to talk to my online audience, can this be done?

A: Sure. by default we allow anyone to enter the chat. You can choose what login option will show in the chat room. 

    The options are: 

    * Guest - anyone can choose a username and Login using a default avatar.
    * Facebook - Login as a Facebook user with facebook avatar.
    * Twitter - Login as a Twitter user with twitter avatar.
    * Register - User can log in after registering to the room.
    * Admins and Users (RumbleTalk Login) - This is a pre-registered list of users. You need to define them upfront in the chat settings (You may set a special avatar per user).  
    * Members - This is actually the option for users to log in automatically using your Drupal users base.

Q: Can I chat with my iPad or iPhone or any other smartphone?

A: Sure, you can add the chat to your website or blog and talk from anywhere.

Q: Can I manage more than a single chat in my account?

A:  Yes. Create one or many rooms. This means you can define several chat rooms in one account (a premium feature). 
    You can integrate each room in different websites (with different domain name).

Q: I want my users to login only with Facebook login, is it possible? 

A: Sure. As an admin, you can decide how users will log in. if you set it up to allow facebook logins, then only the facebook login option will show when a user is asked to log in. 

Q: Can I have different designs for different chats?

A: Yes, you can, For each chat choose your preferred design or if you do not like it, create a design with the chat skin builder or with pure CSS.

Q: My chat height is too small?

A:  RumbleTalk chat is an elastic chat. It means it will consume all the space around it. 
    If that does not work for you, try to use a direct embed, meaning the code we supply for each chat (in the admin panel) can be embedded directly to your website.

Q: Can I use a direct embed in an HTML page?
 
A:  Sure (but not recommended), you can go to the TEXT part in Drupal editor (in each page you have one) and copy paste a code that looks like that.
    Note: you will need to replace the "chatcode" text in this example below with your own 8 digit Rumbletalk code.
    You can also play with the width and height figures.

    <pre>
    Example: 

    &#60;div style="width: 400px; height: 500px;"&#62;
    &#60;script language="JavaScript" type="text/javascript" src="https://www.rumbletalk.com/client/?chatcode"&#62;&#60;/script&#62;
    &#60;/div&#62;
    </pre>

Q: Can I integrate with my members chat?
 
A:  Yes, it is easy to integrate with your Drupal, Buddypress users base.
    The integration is actually a checkbox away.

Q: How to change a member name (the one showing in the chat) when a user is auto-login?

A:  When you login using the auto login (theh members checkbox in the plugin is checked), there is a small arrow next to this check box.
    Click on it and choose the name that will show when one login to the room.

Q: How to login as admin when using the members option for auto-login?

A: If you want to login as admin to the chat, you will need to have the exact same name defined in Drupal users and in Rumbletalk users tab.
    First, create a user at RumbleTalk users tab. Choose an admin NICKNAME.
    Then, create the same name in your Drupal users area.

    Now, when the auto login works, it gets the name from Drupal and then check it against the rumbletalk users.
    If the name is identical (case sensitive), the admin will need to provide a password for the first time.

Q: Is it FREE ?
 
A:  RumbleTalk FREE chat is limited to 5 seats (participants), so it is perfect for small communities and private discussions.
    The Premium version allows you also to talk with more simultaneous chatters, live audio calls, live video calls, private chat, moderations and more.

Q: Can I delete a single message?

A: Sure, log in as admin to the chat and see tray icon next to each message, clicking on it will delete the chat. if you want to clear the entire chat, please use the clear all button (click on the gear icon to see it).

Q: What InText keywords are all about?

A:  RumbleTalk Keywords (InTEXT) uses a smart technology to identify specific words and phrases, and highlight them live, while chat is in process. 
    RumbleTalk InText then dynamically turns these words into predefined links that allow you to associate any word with any web page.
    See video in here https://youtu.be/u3NBNWVy6fk
