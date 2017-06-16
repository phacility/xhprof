all:
	[ -f /usr/lib/php5/build/ltmain.sh ] || \
	 (cd /usr/lib/php5/build && \
	 sudo ln -sf ../../../share/libtool/build-aux/ltmain.sh .)
	cd extension && phpize
	cd extension && ./configure
	cd extension && $(MAKE)
	cd extension && sudo $(MAKE) install
	cd extension && $(MAKE) test
