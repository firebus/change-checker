change_checker
==============

Dave asked me to write a script to watch a certain webpage and a certain twitter feed for the mention of a certain beer being
tapped, so I threw this library together.

## Things that are lame

* Data is persisted in text files, one per ChangeDetector. The text files are created in the directory you run the script from.

## Acknowledgements

* I'm using Stephen Morley's class.Diff.php, which you can find more about at http://code.stephenmorley.org/php/diff-implementation/

## Usage

* See example.php for one way to use this library