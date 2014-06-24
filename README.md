dragonchan
==========

A prototype script to transform any /b/ thread into a dragon slaying match.

Set up (or hijack) any thread using the template below and copy paste it's ID into this URL:


# Offical Domain
- Hosted on AppFog: `http://dragonslayer.eu01.aws.af.cm/[thread_id]`

# Domain Mirror's
- `http://slayer.pw/[thread_id]`
- `http://dragon.slayer.pw/[thread_id]`
- `http://mlp.pw/[thread_id]`


Disclaimer
==========
I`m not posting this threads, random people have been doing that. I have no control over it. If you have complains about the spam, sage the threads yourself.

If you have complains about being banned for posting too many dragon threads in one day, well, its not my fault either.

Please don`t spam with dragon threads or you will end up ruining it for other people.


How to start a dragonchan thread:
================================
_Allways check this page for the correct template before posting. rules will be updated as the game evolves_

__OP options: difficulty@ command__

- `difficulty@noob` - very easy boss
- `difficulty@easy` - default
- `difficulty@medium` - challenging boss
- `difficulty@hard` - almost impossible boss

__OP options: name@ command__

this will set the boss name (no spaces, no numbers):

`name@[desired name]`


__OP options: element@ command__

this will set the boss element:

`element@fire`
`element@ice`
`element@earth`
`element@electric`
`element@water`



POST TEMPALTE:
================
_use the commands described above to configure the boss_
```
ITT: /b/ dragon slayer raid!

Rules:
This huge motherfucking dragon appears out of nowhere.
Read the full rules here: http://dragonslayer.eu01.aws.af.cm

Heres some info about this boss:
name@Dragon
dificulty@easy
element@random

If your ID starts with a number you are a HEALER.
If your ID starts with a vowel you are a BARD.
If your ID starts with "Y","X","Z", a RANGER.
If your ID starts with a "/" or "+" you are a PALADIN.
If your ID ends with a "/" or "+" you are a DEATH KNIGHT.
If your ID starts AND ends with a "/" or "+" you are DRAGONBORN.
If your ID starts with "W","R","L","C" or "K" you are a WARLOCK.
Otherwise you are a KNIGHT

Your last 2 digits represent the damage you do
If you roll under 11 you DIE! (your posts will no longer do damage)
```


FIRST REPLY TEMPLATE:
================
_Dont forget to copy/paste the thread ID into the url_
```
http://dragonslayer.eu01.aws.af.cm/[place thread_id here]


HEALERS revive fallen soldiers
BARDS can boost the party damage by posting images
RANGERS are luck based, better rolls = more damage!
KNIGHTS can critical hit and avenge!
PALADINS can avenge AND revive!
WARLOCKS can summon minions by posting an image.
DEATH KNIGHTS can continue attacking after they die.
DRAGONBORN can avenge and revive when alive, and attack after death.

you can be avenged/revived 6 times max
If you roll 00 or 69 you REVIVE everyone! their damage will count again!
The boss will enrage bellow 20% HP, the minimum roll will be 22. however, he will no longer heal himself
```








Changelog
=========
__v1.7- 09-07-2013__
   - New class: 'Ranger'

__v1.6.5- 30-04-2013__
   - Player commands
   - OP commands
   - sprite fix

__v1.6- 27-04-2013__
   - New Class: 'Dragonborn'
   - Code Cleanup and new sprites
   - Changes to death knight damage output
   - Changes to warlock summon system
   - Adding 'element' mechanics
   - Boss minimum HP is now set to 16.000

__v1.5- 24-04-2013__
   - New Classes: 'Death Knight' and 'Warlock'
   - Added memcache so it doesn`t stress the api
   - Replies to the killer blow now display bellow the winner notification
   - Small fixes on the autoupdater CSS

__version 1.4.5 - 22-04-2013__
   - Massive interface changes
   - new domain: `http://slayer.pw/{THREAD_ID}`
   - new domain: `http://dragon.slayer.pw/{THREAD_ID}`


__version 1.4.1 - 21-04-2013__
   - added: Top deaths stats
   - added: Top bard buff stats
   - adjustments to the fight template

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
  - boss will heal for every kill he does
  - 69 added to the lucky mass revive roll

__v0 - 14-04-2013__
  - First game prototype
  - Last 2 digits represent damage
  - Rolls under 11 die
  - Rolls for 00 will revive everyone
