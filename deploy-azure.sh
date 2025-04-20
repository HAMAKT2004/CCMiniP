#!/bin/bash

# Variables
RESOURCE_GROUP="weather-app-rg"
LOCATION="eastus"
ACR_NAME="weatherappregistry"
APP_SERVICE_PLAN="weather-app-plan"
APP_NAME="php-weather-app"

# Login to Azure (you need to run 'az login' first if not already logged in)

# Create resource group
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create Azure Container Registry
az acr create --resource-group $RESOURCE_GROUP --name $ACR_NAME --sku Basic
az acr update -n $ACR_NAME --admin-enabled true

# Get ACR credentials
ACR_USERNAME=$(az acr credential show --name $ACR_NAME --query "username" -o tsv)
ACR_PASSWORD=$(az acr credential show --name $ACR_NAME --query "passwords[0].value" -o tsv)

# Build and push Docker image to ACR
az acr build --registry $ACR_NAME --image weather-app:latest .

# Create App Service plan
az appservice plan create --name $APP_SERVICE_PLAN --resource-group $RESOURCE_GROUP --is-linux --sku B1

# Create Web App
az webapp create --resource-group $RESOURCE_GROUP --plan $APP_SERVICE_PLAN --name $APP_NAME --deployment-container-image-name "$ACR_NAME.azurecr.io/weather-app:latest"

# Configure Web App
az webapp config appsettings set --resource-group $RESOURCE_GROUP --name $APP_NAME --settings WEBSITES_PORT=80

# Configure container settings
az webapp config container set --name $APP_NAME --resource-group $RESOURCE_GROUP \
    --docker-custom-image-name "$ACR_NAME.azurecr.io/weather-app:latest" \
    --docker-registry-server-url "https://$ACR_NAME.azurecr.io" \
    --docker-registry-server-user $ACR_USERNAME \
    --docker-registry-server-password $ACR_PASSWORD

echo "Deployment completed! Your app should be available at: https://$APP_NAME.azurewebsites.net"