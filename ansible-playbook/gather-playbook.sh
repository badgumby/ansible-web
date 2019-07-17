#!/bin/bash

echo -n "Enter username: "
read USERNAME

echo -n "SSH Password: "
read -s PASSWORD

echo -e "\nGathering info..."

while IFS="" read -r p || [ -n "$p" ]
do
  printf '\n'
  printf '%s\n' "Collecting from $p..."
ansible-playbook -i $p, -u $USERNAME --extra-vars "ansible_password=$PASSWORD ansible_become_password=$PASSWORD" playbook.yml > /srv/serverinfo/inventory/$p.json
done < inventory.lst
