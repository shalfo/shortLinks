# URL shortener excercise

 Write a url-shortener service, similar to tinyurl. The exercise should be time-boxed to 2h; you are free to spend more time if you feel like it, but we won’t value the completeness of the exercise, so skip all productization/industrialization needed, and focus in making a service quick that works – no need to have permanent storage of data, but code should be readable.

## Development

This service has been developed using PHP's Symfony framework. The code in this repository is an implementation approach more than an actual demo, since some key environment elements are missing (for instance the database). Here are the bullet points of the implemented approach:

	-The only values meant to be stored in the database are the actual URLs, the auto generated IDs will be then encoded to a shortString.

	-Cache is appropriate in this case and will provide a performance boost, since stored values are thought to be long term persisting.

	-The main implementation is located at '/src' directory, which contains the following dirs:
		* Controller -> contains the api itself, handles the requests using the featured service
		* Entity -> the url abbreviation object 
		* Repository -> communicates with the eventual database (MySQL)
		* Service -> contains the main logic behind the url shortening and uses the encoding tool which is found in a 	separated 'Utils' directory.
		* Utils -> contins the url shortening algorithm.

	-Besides that, in the 'tests' directory there've been implemented the unit tests for the service.
