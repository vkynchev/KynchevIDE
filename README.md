# KynchevIDE
Kynchev is web-based IDE for web development with small footprint and minimal requirements.

### Content
1. Installation & Requirements
2. Login/Register/Logout
3. Workspaces
4. My ID
5. Projects
6. Files

###Installation & Requirements
#####REQUIREMENTS
KynchevIDE would run on any server where Apache2, MySQL and PHP v5+ are installed. The IDE needs to be placed in domain/subdomain directory to work.
#####INSTALLATION
* Download the KynchevIDE source files from GitHub.
* Place the files in domain/subdomain directory. (Ex: http://your-site.com/ or http://kynchev.your-site.com/)
* Create MySQL database with tables inside:
```

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_position` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_online_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `info_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `info_desc` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `info_avatar` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=1 ;
```
```

--
-- Table structure for table `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `invite_id` int(11) NOT NULL AUTO_INCREMENT,
  `invite_value` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invite_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`invite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
* Update database information in `/config/db.php`. 
* Open KynchevIDE. (Ex: http://your-site.com/ or http://kynchev.your-site.com/)

###Login/Register/Logout
#####LOGIN
As long as this is private platform, you will need account to use it. First when you install the IDE you will be asked to register. The position of the first registered user is 'developer' which means that this user has all permissions in the IDE. 
#####REGISTER
After you have logged in you can change the position on the other users by clicking their star in tab named People. Also you can invite new people to the IDE. After you clicked the Invite button this window will appear. When you click on 'Generate' a link will appear in the field. User cannot be registered without generated link.
#####LOGOUT
You can logout by clicking the circle in the header with the first letter of your name and then by clicking logout.

![Image of People tab](http://webdev.kynchev.eu/github_images/people.PNG)

###Workspaces
#####CREATE
In KynchevIDE you will need a workspace to contain your projects. You can have unlimited workspaces and projects. To create one just type the name of it in the 'Workspace name' field and click 'Add'. If the workspace was created successfully, it will appear in the page.
#####DELETE
If you want to delete a workspace, you will need to click the trash button under the workspace. A window will show and it will be asking you for password to confirm. Like that anyone other than you cannot delete your workspace. If it was deleted successfully, it will disappear from the page.
#####OPEN
Now we know how to create or delete a workspace, but we have one other thing that we can make - to open it and code with love. To open a workspace you will need to click the 'Open' button. After that you will see your projects in the current workspace. To go back to the all workspaces click the home button in the left side of the header.

![Image of Workspaces tab](http://webdev.kynchev.eu/github_images/workspaces.PNG)

###My ID
From My ID page you will be able to change your Name and Description(Avatar, Password and E-mail will be there but in other release). To go there you will click on the circle with the first letter from your name in the right part of the header. From there click 'Manage your profile' option and you will be in My ID page in seconds.

![Image of My ID](http://webdev.kynchev.eu/github_images/my-id.PNG)

###Projects
After you have created a workspace you will need a project to work with. To create one is needed to click on New Project button on the right side of the page. If the project was created it will appear in the page. There is an option for Preview. When you click on it, a new browser tab will open with page where you can select which project you want to view. When you click on a project it will open and reveal the files behind.
#####DOWNLOAD PROJECT
If you want to download a full copy of your project then you can click on the Download Project Button. It's simple!
#####REMOVE PROJECT
If you are tired of your work on the project and you want to delete it there are two ways:
 - The first is to simply click the Remove Project button and verify this operation with your password.
 - The second is to delete all files in the selected project and the IDE will remove it for you.

![Image of Workspace](http://webdev.kynchev.eu/github_images/workspace.PNG)

###Files
When you click on a project the files in it will show up. KynchevIDE has integrated code editor and file viewer. If you click on editable file an editor will show up, but if you click on an image or a video file - a viewer will show up. 
#####Editor
In the IDE is included the ACE editor.
Features:
* Supports over 100 languages
* Search & Replace function
* Autocomplete
* Integrated snippets
* Code highlighting
* Multiple cursors
* Live syntax checker
* Autosave on keyup

![Image of Editor](http://webdev.kynchev.eu/github_images/edit-file.PNG)

#####Viewer
Like the editor there is a viewer for images and videos. To use it simply click on an image or video file and you're done. Now you can view your images or videos direct in your browser.

![Image of Editor](http://webdev.kynchev.eu/github_images/view-file.PNG)

#####FILE OPERATIONS
Create new file:
 - Just click on New File button on the right.
 - Then type the name of your file in the field on top of the file explorer.
 - Last you will need to hit Enter and if everything is ok the file will show up in the list.
 - Tip: To create folders you will need to write the file path for your file. (Ex: new1 > softuniada > `new_folder/file.txt` will create folder `new_folder` and `file.txt` in it)

![Image of Editor](http://webdev.kynchev.eu/github_images/add-file.PNG)

Remove file:
 - To remove file is just needed to click on the Remove File button on the right.
 - The button will be active when a file is opened in editor or viewer.

Upload file:
 - Just drag 'n drop file to the browser.
 - Wait and it will de uploaded to the current directory.


###License

The MIT License (MIT)

Copyright (c) 2015 Viktor Kynchev

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
