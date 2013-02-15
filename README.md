change_checker
==============

Dave asked me to write a script to watch a certain webpage and a certain twitter feed for the mention of a certain beer being
tapped, so I threw this together. It's crappy, but it seems to be working.

## Things that are lame

* Next time I'll put stuff in a library folder and write an autoloader or use composer.
* I don't really know why that interface is there either.
* There should be a config file, but instead you just write everything into ChangeChecker.php, sorry.
* Data is persisted in text files, one per ChangeDetector. The text files are created in the directory you run the script from.

## Acknowledgements

* I'm using Stephen Morley's class.Diff.php, which you can find more about at http://code.stephenmorley.org/php/diff-implementation/

## Usage

* After configuring your notification list and ChangeDetectors in ChangeChecker.php, just run `php check.php`.
