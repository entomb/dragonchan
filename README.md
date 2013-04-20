dragonchan
==========

A prototype script to transform any /b/ thread into a dragon slaying match.

hosted on appfog:
`http://dragonslayer.eu01.aws.af.cm/$THREADID`




Thread Template:
================
```
ITT: /b/ dragon slayer raid!

Rules:
This huge motherfucking dragon appears out of nowhere.
This thread last 2 digits x250 define its HP (plus a flat 3000)

If your ID starts with a number you are a Healer.
If your ID starts with a vowel you are a Bard.
If your ID starts with a "/" or "+" you are a Paladin.
otherwise you are a Knight
Your last 2 digits represent the damage you do
if Knight Roll ends in 5 or 0 you do DOUBLE DAMAGE
If you roll under 11 you DIE! (your posts will no longer do damage)
Bards are here to motive troops! each time they post an image the next 3 posts will do bonus damage!
Healers revive fallen soldiers by targeting them and rolling an EVEN number
Knights avenge fallen soldiers by targeting them and rolling an EVEN number. Avenging does more damage for the glory of the fallen mate.
Paladins can avenge AND revive!
you can be avenged/revived 6 times max
If you roll 00 or 69 you REVIVE everyone! their damage will count again!
The boss will enrage bellow 20% HP, the minimum roll will be 22. however, he will no longer heal himself

I have a webpage to track things, I will post a link to it here.
```



Changelog
=========
__version 1.4 - 20-04-2013__
   - Added an ajax self updating status panel
   - JS Bookmarklet that opens the status panel on any /b/ thread
   - Fixed bug with bard buff only working on pair number roll

__version 1.3.1 - 19-04-2013__
  - added a json export of the current game `$THREADID/json`

__version 1.3 - 19-04-2013__
  - New classes: "Paladin" and "Bard"
  - New global bonus damage mechanic (Bard Buff)
  - Added Top Healer and Top Avenger information
  - Max revive now display a row for each resurection
  - Boosted monster HP by a flat 3000
  - Max revive count incresed from 3 to 6
  - Max avenge count incresed from 3 to 6

__version 1.2 - 19-04-2013__
  - OP is now a regular player. his posts will no longer be ignored

__version 1.1 - 16-04-2013__
  - Incresed chance of avenge/revive
  - Incresed Boss total HP ratio

__version 1 - 15-04-2013__
  - Class system. Knights and Healers
  - New target systems.
  - knights target for more damage
  - Healers target for revive
  - Max 3 targets
  - boss will enrage when bellow 20% HP
  - boll will heal for every kill he does
  - 69 added to the lucky mass revive roll

__v0 - 14-04-2013__
  - First game prototype
  - Last 2 digits represent damage
  - Rolls under 11 die
  - Rolls for 00 will revive everyone
