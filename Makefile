all:
	cd extension && phpize
	cd extension && ./configure
	cd extension && $(MAKE)
	cd extension && sudo $(MAKE) install
	cd extension && $(MAKE) test
