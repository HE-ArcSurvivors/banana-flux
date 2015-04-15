echo "Starting the script, tmp files will be created"
cd /Applications/MAMP/htdocs/BananaRocket
mkdir mirror
cd mirror
echo "Start Cloning"
git clone --mirror https://isic-lan.he-arc.ch/git/1415-appweb-g1.git
cd 1415-appweb-g1.git
echo "Start Pushing"
git push --mirror https://rocla@bitbucket.org/bananarocket/application-web.git
rm -fr /Applications/MAMP/htdocs/BananaRocket/mirror
echo "Finished and Cleaned"