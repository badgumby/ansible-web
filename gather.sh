#!/bin/bash

echo -n "Enter username: "
read USERNAME

echo -n "SSH Password: "
read -s PASSWORD

while IFS="" read -r p || [ -n "$p" ]
do
  printf '\n'
  printf '%s\n' "Collecting from $p..."
  ansible -m setup -i $p, all -u $USERNAME --extra-vars "ansible_password=$PASSWORD" > /serverinfo/inventory/$p.json
  eval "sed -i '1 s/^.*$/{/' /serverinfo/inventory/$p.json"
done < inventory.lst
