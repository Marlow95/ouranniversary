FROM nginx:alpine

RUN rm /etc/nginx/conf.d/default.conf

RUN echo 'include /etc/nginx/mime.types; \
\
server { \
    listen 80; \
    server_name ouranniversary.marlow.pro; \
    return 301 https://$host$request_uri; \
} \
server { \
    listen 443 ssl; \
    server_name ouranniversary.marlow.pro; \
    root /usr/share/nginx/html; \
    index index.html; \
    \
    ssl_certificate /etc/letsencrypt/live/ouranniversary.marlow.pro/fullchain.pem; \
    ssl_certificate_key /etc/letsencrypt/live/ouranniversary.marlow.pro/privkey.pem; \
    \
    location / { \
        types { } default_type text/html; \
        try_files $uri $uri/ /index.html; \
    } \
}' > /etc/nginx/conf.d/my-site.conf

COPY . /usr/share/nginx/html

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]