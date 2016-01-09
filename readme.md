## LaravelDFW Website

LaravelDFW is a community of Dallas / Fort Worth Laravel Artisans. This is the site about their group.

## Official Website
The official website (production version of this app) is at [http://www.laraveldfw.com](http://www.laraveldfw.com).

### Install Instructions
*These instructions assume a project name/directory of `laraveldfw`.
1. Clone the git repo `git clone [repo-path] laraveldfw`
2. Navigate into the newly created git repo: `cd laraveldfw`
3. Install composer packages needed for this project: `composer install`

**You will now have a project installation of homestead**
More info on the [Laravel Website](https://laravel.com/docs/5.2/homestead#per-project-installation).
1. Generate the homestead files for the application:
    * Mac / Linux `php vendor/bin/homestead make`
    * Windows `vendor\bin\homestead make`
2. Run the application: `vagrant up`

**Remember**, you will still need to add an `/etc/hosts` file entry for homestead.app or the domain of your choice, i.e. laraveldfw.dev. The domain in the Homstead.yaml needs to match the entry in you `/etct/hosts` file.

Now simply navigate to the url you specified above and the app will be up and running!
