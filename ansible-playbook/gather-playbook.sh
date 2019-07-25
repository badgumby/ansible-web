#!/bin/bash

echo -n "Enter username: "
read USERNAME

echo -n "SSH Password: "
read -s PASSWORD

echo -e "\nGathering info..."

while IFS="" read -r p || [ -n "$p" ]
do
  host=$(echo "$p" | tr '[a-z]' '[A-Z]')
  printf '\n'
  printf '%s\n' "Collecting from $host..."
  # Remove port from filename
  shortname=$(echo "$host" | awk -F: '{print $1}')
  printf '%s\n' "Filename: $shortname"
ansible-playbook -i $host, -u $USERNAME --extra-vars "ansible_password=$PASSWORD ansible_become_password=$PASSWORD" playbook.yml > /srv/serverinfo/inventory/$shortname.json
done < inventory.lst
