using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.DependencyInjection;
using System.Net.Http;
using System.Threading.Tasks;

// Crea un constructor de la aplicación web
var builder = WebApplication.CreateBuilder(args);

// Agrega un servicio HttpClient con el nombre de tipo TenorService al contenedor de servicios
builder.Services.AddHttpClient<TenorService>(); 

// Construye la aplicación
var app = builder.Build();

app.UseHttpsRedirection();

app.MapGet("/api", async (HttpClient httpClient) =>
{
    var url = $"https://g.tenor.com/v1/search?q=excited&key=LIVDSRZULELA&limit=8";
    var response = await httpClient.GetStringAsync(url);

    return response;
})
.WithName("GetExcitedGifs")
.WithOpenApi();

app.Run();

public class TenorService
{
    private readonly HttpClient _httpClient;

    public TenorService(HttpClient httpClient)
    {
        _httpClient = httpClient;
    }
}
