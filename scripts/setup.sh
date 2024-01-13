# Replace Lando site URL and name
read -p "What is the machine name of your local site? [site-name]: " site_name
site_name=${site_name:-site-name}
sed -i '' "s/local-drupal-dev/$site_name/g" .lando.yml

# Change origin of git repo
read -p "What is the git URL for this new site? [git@github.com:codechefmarc/$site_name.git]: " git_url
git_url=${git_url:-"git@github.com:codechefmarc/$site_name.git"}
git remote set-url origin $git_url

# Lando init
lando rebuild -y
lando start

#Composer install
lando composer install