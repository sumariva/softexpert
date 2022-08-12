echo 'Copying assets to public folder...'
cp -r src/assets public
echo 'Copying js libraries to public folder...'
mkdir -p public/js
cp node_modules/jquery/dist/jquery.min.js public/js
echo 'Copying view js files to public folder...'
cp src/main.js public/js
