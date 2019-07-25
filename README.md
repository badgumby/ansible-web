# ansible-web
A web interface for reviewing the data returned from the `setup` module from a list of Ansible servers

#### serverinfo
>This directory holds the web site.

#### ansible-playbook
>This directory hold the ansible playbook and script.

###### ansible.cfg

>This is my standard ansible.cfg. Whatever directory you run this from must have an ansible.cfg file with the minimum added:

```
[defaults]
stdout_callback = json
bin_ansible_callbacks = True
```

###### gather-playbook.sh
>The shell script that gathers the info using ansible `setup`. This needs to be modified to point to wherever you place the `/serverinfo/` directory. You can also set the username and password as variables, then schedule a cron job to run this regularly.

###### inventory.lst
>List of servers that `gather-playbook.sh` uses to gather info (one per line). You can specify a different port (22 is used by default) by appending `:PORT_NUMBER` on the name/IP.

## Known Issues
 - Package gathering (`package_facts`) is not working on Ubuntu 18.04 Server.
