# Utiliza la imagen base de .NET Core SDK para compilar la aplicación
FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
WORKDIR /src

# Copia el archivo csproj y restaura las dependencias
COPY GifApiTenor.csproj .
RUN dotnet restore

# Copia el resto de los archivos y realiza la compilación
COPY . .
RUN dotnet publish -c release -o /app

# Crea una nueva imagen base de .NET Core para ejecutar la aplicación
FROM mcr.microsoft.com/dotnet/aspnet:8.0

# Establece el directorio de trabajo en /app
WORKDIR /app

# Copia los archivos publicados de la etapa de compilación a la imagen final
COPY --from=build /app .

# Establece el punto de entrada para la aplicación
ENTRYPOINT ["dotnet", "GifApiTenor.dll"]
