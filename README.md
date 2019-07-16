# ansible-web
A web interface for reviewing the data returned from the `setup` module from a list of Ansible servers

###### serverinfo
>This directory holds the web site.

###### gather.sh
>The shell script that gathers the info using ansible `setup`. This needs to be modified to point to wherever you place the `/serverinfo/` directory. You can also set the username and password as variables, then schedule a cron job to run this regularly.

###### inventory.lst
>List of servers that `gather.sh` uses to gather info (one per line)
