.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: install
install:                                                              			## Install all dependencies for a development environment
	composer install

.PHONY: coding-standard-check
coding-standard-check:                                                          ## Check coding-standard compliance
	./vendor/bin/phpcs --basepath=. --standard=config/phpcs.xml
	composer validate
	composer normalize --dry-run

.PHONY: coding-standard-fix
coding-standard-fix:                                                            ## Apply automated coding standard fixes
	./vendor/bin/phpcbf --basepath=. --standard=config/phpcs.xml
	composer normalize

.PHONY: check
check: coding-standard-check                                                   ## Run all checks for local development iterations
