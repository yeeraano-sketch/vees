.PHONY: test lint clean

test:
	vendor/bin/phpunit

lint:
	vendor/bin/pint --test

fix:
	vendor/bin/pint

clean:
	rm -rf vendor composer.lock
	composer install
