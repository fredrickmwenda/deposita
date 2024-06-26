#!/bin/bash

# Directories to check
# directories=("app" "assets" "config" "database" "lang" "public" "routes" "resources" "storage" "tests" "folder")

# # Loop over the directories , check up
# for directory in ${directories[@]}; do
#   # Get the list of all files that have been added or modified in the directory
#   files=$(git diff --name-only --diff-filter=AM HEAD^ HEAD -- $directory)

#   # Loop over the files
#   for file in $files; do
#     # Check if the file contains new code
#     if git diff HEAD^ HEAD -- $file | grep -q '^+'; then
#       # Replace this echo command with the command to run your tests
#       echo "Running tests on $file..."
#     fi
#   done
# done
