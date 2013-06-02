nytimes_catbubbles
==================

A series of scripts to generate thematic bubble lines and network files using metadata retrieved from the New York Times archive. Use a text query and explore how that query relates to the indexing of the NY Times staff.

For further explanation on what this does, go here: http://thepoliticsofsystems.net/?p=637

Make it work
============
1) Get a New York Times search API key here: http://developer.nytimes.com/apps/mykeys

2) Put all scripts into a folder and set write permissions for everybody

3) Modify conf.php with your query and your API key

4) Run grab.php and wait - when finished,

__a) to generate the bubble lines:__

5) Run analyze.php (possibly modify value for $minyears) and wait

6) Modify the .R scripts to use the .csv file you just generated (possibly modify year cutoff)

7) Run .R scripts

__b) to generate a network file (gexf format)__

5) Run network.php and wait
