nytimes_catbubbles
==================

A series of scripts to generate thematic bubble lines for subjects queried in the New York Times archive.

For further explanation on what this does, go here: http://thepoliticsofsystems.net/?p=637

Make it work
============
1) Get a New York Times search API key here: http://developer.nytimes.com/apps/mykeys
2) Put all scripts into a folder and set write permissions for everybody
3) Modify conf.php with your query and your API key
4) Run grab.php and wait - when finished,
5) Run analyze.php and wait
6) Modify the .R scripts to use the .csv file you just generated
7) Run .R scripts
