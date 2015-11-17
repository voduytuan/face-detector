# face-detector

### Docker container running
You can start new container from this image or build your image from my `Dockerfile`. This image is already had a web server running in Apache, PHP and web services will start after start container.

```bash
docker run -ti -d --name facedetector -p 80:80 voduytuan/face-detector
```

### Request
Upload file with form-data field name `image`.
Image must be JPG and size under 5MB. You can change this size in index.php file before building new docker image or mount volume with new index.php file.

There are two web services, `count` and `face`. With `count` web service, using your URL with `?action=count`, this will return the number of face detected in uploaded image.

If not passing query string action, default web service is get all faces information (`x`, `y`, `w`, `h`).

### Sample response of Count service
Success: 

```json
{
	"success": true,
	"message": "",
	"count": 1
}
```

Error: 

```json
{
	"success": false,
	"message": "Image is required.",
	"count": 0
}
```

### Sample response of Face service
Success: 

```json
{
	"success": true,
	"message": "",
	"faces": [
		{"x":985,"y":482,"w":303,"h":303}
	]
}
```

Error: 

```json
{
	"success": false,
	"message": "Image must be in JPG format.",
	"faces": []
}
```

--End--

