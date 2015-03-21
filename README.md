# Text Truncator
Limit paragraphs of text and append "read more" links or ellipses.  

## Usage
```
require "vendor/autoload.php";

$truncator = new Kouz\TextTruncator();
$truncator->setLimit(10);
$truncator->setEnding("...");

echo $truncator->limitChars("Limit text to 10 characters");

//Limit text...

echo $truncator->limitWords("Limit text to ten words, six seven eight nine ten eleven");

//Limit text to ten words, six seven eight nine ten...
```
