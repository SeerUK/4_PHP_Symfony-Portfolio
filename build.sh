#!/bin/sh

# Minify CSS:
cd /var/www/sym.pde.com/4_PHP_Symfony-Portfolio/public_html/web/static/css

rm -f *.min.css
for file in *.css
do
	echo "Minifying::"${file}
	java -jar /home/seer/Bin/YUI/yuicompress.jar ${file} -o ${file%.*}.min.css
done

# Minify JS
cd ../js

rm -f *.min.js
for file in *.js
do
	echo "Minifying::"${file}
	java -jar /home/seer/Bin/YUI/compiler.jar --js ${file} --js_output_file ${file%.*}.min.js
done