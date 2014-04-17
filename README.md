Image Clerk
-----------

#### Create Persistant Image Thumbnails

Because image thumbnails are generated at page render and are placed in the cache, these thumbnails can disappear when clearing out cache files.

Image Clerk generates thumbnails on request so that they are always available.

Image Clerk uses the same familiar interface as the core `ImageHelper`

```php
Loader::helper('image_clerk', 'image_clerk')->outputThumbnail($file, 200, 200, true);
```

```php
$img = Loader::helper('image_clerk', 'image_clerk')->getThumbnail($file, 200, 200, true);
```
