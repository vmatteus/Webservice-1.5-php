.PHONY: tests

tests:
	@./vendor/bin/phpunit -c phpunit.xml.dist
