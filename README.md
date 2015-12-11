GENOMEPRO 2.0

Code Directory Structure:
-------------------------
website:                                  -- source code of all the web site components
database:                                 -- backups of database structure and schema
installationGuide:                        -- how to install GenomePro on a fresh server
userManual:                               -- simple guide on how to use GenomePro 2.0


Web Site Directory Structure:
-----------------------------
> var
    > www
        > html
            > avatars                     -- user avatars
                > *.jpg
                > *.png
                > ...
            > config
                > config.php              -- contains PHP definitions (global variables)
            > core
                > core.php                -- in every PHP page. autoloads all libraries
            > delivery                    -- FTP section. password protected user files
                > user1
                    > index.php           -- copied from helpers/ftp. makes viewing nicer
                    > uploads             -- files uploaded by user. some form of DNA
                        > u1_file1.*
                        > u1_file2.*
                        > ...
                    > results             -- result of tools arranged by folders
                        > u1_out1         -- the actual name of these folders contain job id
                            > *.*
                            > ...
                        > u1_out2
                            > *.*
                            > ...
                        > ...
                > ...
            > helpers
                > cron
                    > cron.helper.php     -- locks crons from running over each other.
                    > db_cleaner.php      -- runs once a day. cleans uncomfirmed users for now.
                    > file_validator.php  -- validates uploaded files for validity.
                    > job_processor.php   -- processes jobs from the database and stores results.
                > ftp
                    > index.php           -- this gets copied when user created or password changed.
                > mailer                  -- PHPMailer stuff. only kept the bare minimum.
                    > *.*                 -- we're using a GenomePro gmail to send emails.
                    > ...
                > db_helper.php           -- currently empty. Poor guy never got love.
                > format_helper.php       -- functions stored here that format dates, etc.
                > system_helper.php       -- super versatile guy. Moves files, creates FTP for users, and more.
            > libraries                   -- the models of the site
                > Database.php            -- the only model that runs queries and returns results of queries.
                > File.php                -- contains functions to grab and set files from and to the database.
                > Job.php                 -- same as files, but with jobs instead.
                > Template.php            -- the pseudo-mvc guy. this is the controllers means to communicate with view.
                > Tool.php                -- same as files, but with tools instead.
                > User.php                -- same as files, but with users instead.
                > Validator.php           -- just checks up on formatting, like when registering, passwords match, etc.
            > programs                    -- run of the mill location where C programs are stored.
                > source                  -- any source files, sample input, trashy stuff stored here.
                    > *.*
                    > ...
                > extract                 -- one of the programs GenomePro uses.
                    > extract.exe         -- the actual executable. most programs follow this format.
                > probes
                    > probes.exe
                > ...
            > templates                   -- HTML code for the site. Controllers pull from here onto TEMPLATE.
                > css
                    > *.*
                    > ...
                > data
                    > *.*
                    > ...
                > fonts
                    > *.*
                    > ...
                > ...
                > about.php               -- the views of the site.
                > charts.php
                > contact.php
                > ...
            > about.php                   -- although similar name, don't be confused! These are the controllers.
            > charts.php
            > contact.php
            > ...


GenomePro Site:
----------------
http://genomepro.cis.fiu.edu/