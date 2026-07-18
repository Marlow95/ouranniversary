# Use the official Nginx image
FROM nginx:alpine

# Copy your local website files into the Nginx directory
COPY . /usr/share/nginx/html

# Copy your custom Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]