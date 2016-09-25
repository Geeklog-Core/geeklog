run-tests:
	make -C tests run-tests


phpdoc: 
	monotone log > CHANGELOG
	make -C docs phpdoc
	cp CHANGELOG XML
	phpdoc --directory XML,docs/tutorials --examplesdir docs/examples --target docs/phpdoc --title "XML_RPC2 Documentation" --parseprivate --defaultpackagename XML_RPC2 --pear -ric --output HTML:Smarty:PHP 
	rm -f XML/CHANGELOG

clean: 
	make -C tests clean
	rm -Rf docs/phpdoc
	rm -f CHANGELOG
