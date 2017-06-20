# Draco Universal Search

The universal search module provides a framework for outputting UDI data into
XML feeds required by Apple, Amazon and Roku for their Universal Search 
products. Universal Search allows end users to search for media content in a
single place and get results to view media on the appropriate app or service.
Each Universal Search provider requires content providers to submit their entire
catalog of avilable media, including metadata, pricing, and view location.

The module works by using Content title entities from UDI module as a basis for
the media items that make it into the feed. UDI data is incomplete. Date which
is absent is required to be provided by brands when integrating this module
into their site. Assuming content title data from upstream is reasonably 
complete, typically brands are required to add at least the following:

* Artwork
* Availability
* Pricing

## Installation

### For brand developers

This is the recommended method for brands to use for this and all other Draco
modules.

To download the module with composer, require the Draco Universal Search module, 
which will automatically pull in all dependent modules and libraries.

```
$ composer require vgtf/draco_universal_search
```

Then, follow steps 3 onwards from the following section to complete
the installation.

### For Draco developers

We recommend that all Draco module development be done with a stock Drupal 8
installation. In that case:

1. Clone this repository into modules/custom.

2. Make the following adjustments to you root's `composer.json`:

2.2. Require the following plugins:
```
    "require": {
        "wikimedia/composer-merge-plugin": "dev-master",
        "cweagans/composer-patches": "~1.0"
```

2.3. Add `draco_universal_search/composer.json` to the `merge-plugin` section:
```
   "extra": {
        "merge-plugin": {
            "include": [
                "core/composer.json",
                "[PATH TO]/draco_universal_search/composer.json"
            ]
```

3. Install the module: `drush en -y draco_universal_search`.

4. In order to generate a feed, you need to have at least some UID data imported
   info your Drupal instance. See Draco UDI documentation for details.
    
At this point you should be able to view the feed of data, which is available at
the following endpoints:

/universal-search-feed?_format=apple_us_catalog

@todo Add other endpoints once implemented.

@todo Testing instructions
