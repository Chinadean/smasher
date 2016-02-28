# Smasher - Smash your directories 

> Turn your directory structure to array, Json, ~~XML or YML~~ and vice versa.

## What?
Smasher is a utility that lets you **get a JSON, array, ~~XML or YML~~ representation from your directory structure**, or **use the specified representations to create the directory structure**

When you *smash* a directory, all the subdirectories, files, symlinks are converted to the representation that you need and when you *build*, the representaion is processed to create the specified structure i.e. directories, files and symlinks are automatically created.

> ..all the subdirectories, files, symlinks are converted to the representation that you need ...and back

## Installation
The recommended way of installation is using composer. Update your project's `composer.json` file and add the following:

```
{
    "require": {
        "kamranahmedse/smasher": "*"
    }
}
```

And run `composer install` or simply run 

```
composer require kamranahmedse/smasher
```

## How to use?

Currently `json` and `array` are the only supported representations however the support for the `xml` and `yml` representations is on it's way. However if you are in a hurry, I will show you how easy it is to do that in a moment.

Let's stick to the topic, how to use, for now.

**Introducing the classes** First things first, introduce the classes that we are going to use, in your scope.

```php
// Introduce the classes into your scope
use KamranAhmed\Smasher\Scanner;
use KamranAhmed\Smasher\JsonResponse;
```

**Smashing a directory** Generating JSON representation from the directory

```
// Instantiate the scanner class while passing the object
// of which type you need the response. Currently there is
// only JsonResponse that we have so..
$scanner = new Scanner(new JsonResponse());

// Scan the directory and return the JSON for the available content
$dirJson = $scanner->scan('/directory/to-scan');

// Or you can provide the path at which the json representation should
// be stored i.e.
// $scanner->scan('directory/to-scan', 'output/to-scan.json');

```

**..back to directory structure** Turning the JSON representation back to directory structure

```
// Instantiate the scanner class while passing the object
// of which representation that you are going to use. We are going
// to convert JSON back to directory structure
$scanner = new Scanner(new JsonResponse());

// Specify the path where you need to populate the content in JSON
// Let's populate the directory structure in the JSON representation
// inside the output directory
$scanner->populate('output/', 'path/to/representation/to-use.json');
```

## The Format

Let's say I had the following directory structure:

```
- sample-path
    - child-item
        - grand-child
            - child-file.md         // A file with specified content
              (Some content in the child file.)
        - grand-child-sibling
            - empty-file            // A file having no content
    - child-sibling
        - nothing-in-this-file.txt  // A file having no content
    - child-sibling-2
        - sibling-child
            - empty-file            // A file with no content
            - some-link
            - some-file
             (Text inside some-file)
```

It will produce the following output:

Also note that: `@` symbol in the beginning of a key represents the property and the keys without the `@` symbol represents a directory

```json
{
   "sample-path":{
      "@name":"sample-path",
      "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path",
      "@type":"dir",
      "@size":170,
      "@mode":"0755",
      "@owner":{
         "name":"kamranahmed",
         "passwd":"********",
         "uid":501,
         "gid":20,
         "gecos":"Kamran Ahmed",
         "dir":"\/Users\/kamranahmed",
         "shell":"\/bin\/zsh"
      },
      "@last_modified":"2016-02-27 07:24:19",
      "@group":{
         "name":"staff",
         "passwd":"*",
         "members":[
            "root"
         ],
         "gid":20
      },
      "child-item":{
         "@name":"child-item",
         "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-item",
         "@type":"dir",
         "@size":136,
         "@mode":"0755",
         "@owner":{
            "name":"kamranahmed",
            "passwd":"********",
            "uid":501,
            "gid":20,
            "gecos":"Kamran Ahmed",
            "dir":"\/Users\/kamranahmed",
            "shell":"\/bin\/zsh"
         },
         "@last_modified":"2016-02-27 07:24:19",
         "@group":{
            "name":"staff",
            "passwd":"*",
            "members":[
               "root"
            ],
            "gid":20
         },
         "grand-child":{
            "@name":"grand-child",
            "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-item\/grand-child",
            "@type":"dir",
            "@size":102,
            "@mode":"0755",
            "@owner":{
               "name":"kamranahmed",
               "passwd":"********",
               "uid":501,
               "gid":20,
               "gecos":"Kamran Ahmed",
               "dir":"\/Users\/kamranahmed",
               "shell":"\/bin\/zsh"
            },
            "@last_modified":"2016-02-27 07:24:19",
            "@group":{
               "name":"staff",
               "passwd":"*",
               "members":[
                  "root"
               ],
               "gid":20
            },
            "child-file.md":{
               "@name":"child-file.md",
               "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-item\/grand-child\/child-file.md",
               "@type":"file",
               "@size":32,
               "@mode":"0644",
               "@owner":{
                  "name":"kamranahmed",
                  "passwd":"********",
                  "uid":501,
                  "gid":20,
                  "gecos":"Kamran Ahmed",
                  "dir":"\/Users\/kamranahmed",
                  "shell":"\/bin\/zsh"
               },
               "@last_modified":"2016-02-27 07:24:19",
               "@group":{
                  "name":"staff",
                  "passwd":"*",
                  "members":[
                     "root"
                  ],
                  "gid":20
               },
               "@content":"Some content in the child file.\n"
            }
         },
         "grand-child-sibling":{
            "@name":"grand-child-sibling",
            "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-item\/grand-child-sibling",
            "@type":"dir",
            "@size":102,
            "@mode":"0755",
            "@owner":{
               "name":"kamranahmed",
               "passwd":"********",
               "uid":501,
               "gid":20,
               "gecos":"Kamran Ahmed",
               "dir":"\/Users\/kamranahmed",
               "shell":"\/bin\/zsh"
            },
            "@last_modified":"2016-02-27 07:24:19",
            "@group":{
               "name":"staff",
               "passwd":"*",
               "members":[
                  "root"
               ],
               "gid":20
            },
            "empty-file":{
               "@name":"empty-file",
               "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-item\/grand-child-sibling\/empty-file",
               "@type":"file",
               "@size":0,
               "@mode":"0644",
               "@owner":{
                  "name":"kamranahmed",
                  "passwd":"********",
                  "uid":501,
                  "gid":20,
                  "gecos":"Kamran Ahmed",
                  "dir":"\/Users\/kamranahmed",
                  "shell":"\/bin\/zsh"
               },
               "@last_modified":"2016-02-27 07:24:19",
               "@group":{
                  "name":"staff",
                  "passwd":"*",
                  "members":[
                     "root"
                  ],
                  "gid":20
               },
               "@content":""
            }
         }
      },
      "child-sibling":{
         "@name":"child-sibling",
         "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling",
         "@type":"dir",
         "@size":102,
         "@mode":"0755",
         "@owner":{
            "name":"kamranahmed",
            "passwd":"********",
            "uid":501,
            "gid":20,
            "gecos":"Kamran Ahmed",
            "dir":"\/Users\/kamranahmed",
            "shell":"\/bin\/zsh"
         },
         "@last_modified":"2016-02-27 07:24:19",
         "@group":{
            "name":"staff",
            "passwd":"*",
            "members":[
               "root"
            ],
            "gid":20
         },
         "nothing-in-this-file.txt":{
            "@name":"nothing-in-this-file.txt",
            "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling\/nothing-in-this-file.txt",
            "@type":"file",
            "@size":0,
            "@mode":"0644",
            "@owner":{
               "name":"kamranahmed",
               "passwd":"********",
               "uid":501,
               "gid":20,
               "gecos":"Kamran Ahmed",
               "dir":"\/Users\/kamranahmed",
               "shell":"\/bin\/zsh"
            },
            "@last_modified":"2016-02-27 07:24:19",
            "@group":{
               "name":"staff",
               "passwd":"*",
               "members":[
                  "root"
               ],
               "gid":20
            },
            "@content":""
         }
      },
      "child-sibling-2":{
         "@name":"child-sibling-2",
         "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling-2",
         "@type":"dir",
         "@size":136,
         "@mode":"0755",
         "@owner":{
            "name":"kamranahmed",
            "passwd":"********",
            "uid":501,
            "gid":20,
            "gecos":"Kamran Ahmed",
            "dir":"\/Users\/kamranahmed",
            "shell":"\/bin\/zsh"
         },
         "@last_modified":"2016-02-27 07:24:19",
         "@group":{
            "name":"staff",
            "passwd":"*",
            "members":[
               "root"
            ],
            "gid":20
         },
         "empty-file":{
            "@name":"empty-file",
            "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling-2\/empty-file",
            "@type":"file",
            "@size":0,
            "@mode":"0644",
            "@owner":{
               "name":"kamranahmed",
               "passwd":"********",
               "uid":501,
               "gid":20,
               "gecos":"Kamran Ahmed",
               "dir":"\/Users\/kamranahmed",
               "shell":"\/bin\/zsh"
            },
            "@last_modified":"2016-02-27 07:24:19",
            "@group":{
               "name":"staff",
               "passwd":"*",
               "members":[
                  "root"
               ],
               "gid":20
            },
            "@content":""
         },
         "sibling-child":{
            "@name":"sibling-child",
            "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling-2\/sibling-child",
            "@type":"dir",
            "@size":102,
            "@mode":"0755",
            "@owner":{
               "name":"kamranahmed",
               "passwd":"********",
               "uid":501,
               "gid":20,
               "gecos":"Kamran Ahmed",
               "dir":"\/Users\/kamranahmed",
               "shell":"\/bin\/zsh"
            },
            "@last_modified":"2016-02-27 07:24:19",
            "@group":{
               "name":"staff",
               "passwd":"*",
               "members":[
                  "root"
               ],
               "gid":20
            },
            "some-file":{
               "@name":"some-file",
               "@path":"\/Users\/kamranahmed\/Workspace\/hq\/public\/test\/json-to-dir\/tests\/data\/sample-path\/child-sibling-2\/sibling-child\/some-file",
               "@type":"file",
               "@size":22,
               "@mode":"0644",
               "@owner":{
                  "name":"kamranahmed",
                  "passwd":"********",
                  "uid":501,
                  "gid":20,
                  "gecos":"Kamran Ahmed",
                  "dir":"\/Users\/kamranahmed",
                  "shell":"\/bin\/zsh"
               },
               "@last_modified":"2016-02-27 07:24:19",
               "@group":{
                  "name":"staff",
                  "passwd":"*",
                  "members":[
                     "root"
                  ],
                  "gid":20
               },
               "@content":"Text in side somefile\n"
            }
         }
      }
   }
}
```

### Extending to support other formats

In order to extend `smasher` for other formats, all you have to do is create a response class by implementing the `KamranAhmed\Smasher\Contracts\ResponseContract` and pass the instance of that class to the `Scanner` object

```
class SuperResponse implements ResponseContract {

    /**
     * Formats the passed data for example a `JsonResponse` will encode to json, `XMLResponse`
     * will encode to xml etc
     * @param  array $data The data which is to be encoded
     * @return string
     */
    public function encode($data) {
        // Put your logic to convert a nested array to 
        // *super response format* here and return the resulting string
    }
    
    /**
     * Decodes the passed string and creates array from it
     * @param  string $response The existing response which is to be decoded to array
     * @return array
     */
    public function decode($response) {
        // Put your logic to convert the $response string to
        // to a nested array, like the one you encoded, and return
        // the array
    }
}


// Then pass it to scanner object
$scanner = new Scanner(new SuperResponse);

// Directory structure will be transformed to the format you need and 
`output/to-scan.super` file will be created
$scanner->scan('path/to-scan', 'output/to-scan.super');

// To create the directory structure from the response.
$scanner->populate('output/', 'to-scan.super');
```

### Contributing

Contribute to the package by reporting any bugs/suggestions adding support for additional formats or enhancing/improving the available functionality


