all:
	[ -f /usr/lib/php5/build/ltmain.sh ] || \
	 (cd /usr/lib/php5/build && \
	 sudo ln -sf ../../../share/libtool/build-aux/ltmain.sh .)
	cd extension && phpize
	cd extension && ./configure
	# run tests with `php5`, not with `php` which may be version 7
	sed -i 's%^\(PHP_EXECUTABLE = /usr/bin/php\)$$%\15%' extension/Makefile
	cd extension && $(MAKE)
	cd extension && sudo $(MAKE) install
	cd extension && $(MAKE) test
