# Project Management - Cemetery Project 

Useful Documentation/Sources:
  [Symfony](https://symfony.com/doc/current/index.html)
  [Twig](https://twig.symfony.com/doc/2.x/)
  

Installation Instructions & Getting Started

Most of this will be for Windows systems as that is the majority of the group.

Download PHP 7.4.28 Zip [Here](https://windows.php.net/download/)
Download Composer-Setup.exe [Here](https://getcomposer.org/download/)

To install Composer & PHP:
  Extract the PHP binary files and save them to your Documents folder.
  Run the Composer-Setup.exe file and follow the prompts. When asked for the PHP file, "Browse" to the php folder and select the PHP.exe file. You may want to turn on file extensions. Do that [here](https://fileinfo.com/help/windows_10_show_file_extensions)

Install Scoop [Here](https://scoop.sh/) (If this fails the first time, disable antivirus and retry)
Use Scroop to Install Symfony [Here](https://symfony.com/download)

Download the MSSQL Driver for PHP [Here](https://github.com/Microsoft/msphpsql/releases/tag/v5.10.0)
Pick the one according to your OS. Most will be Windows (towards the bottom). Make sure you get the 7.4 version (there are 3 versions of each. These are the PHP version it works for).
Extract this folder. Copy the php_pdo_sqlsrv_74_nts.dll file to your php/ext folder (wherever you put it). This is a sub folder within the PHP install folder.

Next we get to change the php.ini file. (Again, you will need to turn on visible extensions for this. Find that [here](https://fileinfo.com/help/windows_10_show_file_extensions)).
Ctrl+F to find "curl". The first one should result in a "block" of extension lines.
Uncomment the lines with these plugins:
  curl
  fileinfo
  intl
  imap
  mbstring
  openssl
  
And finally, add this line to the bottom of that extension block:
  extension=php_pdo_sqlsrv_74_nts_x64.dll
  
Save the file and close it.

Clone this GitHub repo to a folder somewhere and open it in your editor of choice.
I will use the Windows Terminal for this, but opening the terminal in VSCode will be similar.

Using Windows Terminal:
If using VSCode, skip past this section...
  cd into the project folder, wherever you put it. Mine was in 
    > cd "C:\Users\Daniel Boling\Documents\Cemetery Project\cemetery_project\"
    
After in the working directory:
  run
    > composer install
    > composer update
  finally, start the dev server with
    > symfony server:start -d
   
   
You should see a prompt saying the site is running. Follow any other prompts (you may see one about a ca:certificate. Go ahead and run that command). If you visit [localhost:8000](localhost:8000) you should get a Symfony page, or the project loaded, depending on the project files.

Happy Coding!!
