#wuanlife_console配置说明

    cd /home/www/html
    git clone https://github.com/wuanlife/wuanlife_console.git
    cd /etc/nginx/conf.d
    wget https://raw.githubusercontent.com/wuanlife/wuanlife_console/config/console.conf
    systemctl reload nginx

访问http://YourIP:808 即可，默认登录用户为wuanlife第一个用户
