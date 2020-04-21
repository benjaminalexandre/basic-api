# Basic Api
This a basic API built with Symfony 5 

## Table of Contents
* [Installation](#installation)
* [Architecture](#why-and-how-)
    * [Domain Driven Design](#domain-driven-design)
    * [Command Query Responsibility Segregation](#command-query-responsibility-segregation)
    * [Abstraction and implementation](#abstraction-and-implementation)
    * [ParamConverter](#paramconverter)
    * [AutoMapper](#automapper)
    * [NelmioApiDocBundle](#nelmioapidocbundle)
* [TODO List](#todo-list)

## Installation
Clone the repository and install composer packages
```bash
$ composer install
```

## Architecture
This API is a base that I use to build my applications. 

### Domain Driven Design

It uses the principle of **DDD (Domain Driven Design)** which is a design technique that allows simple communication between the layers of the application.
This principle is cut into 5 layers :
- **Application** : 
   - Coordinates application activities. 
   - Responsible for retrieving objects from the domain via the _repository_ to "inject" dynamics into the domain.
   - In charge of adding or deleting objects in the _repository_. 
- **Core** :
   - Utils et Helper. Functions found in them are not dependent on anything.
- **Domain** :
   - Contains all the classes corresponding to the elements of the domain model.
- **Http** :
   - Contains all the initialization part of the product and acts as a receptacle for HTTP requests.
   - Contains the middleware (EventListener, ParamConverter), exceptions and Controllers that are used to route requests to the application layer.
- **Repository** :
   - Serves the other layers and avoids bringing non-business complexity where it is not needed.
   - Persists our data and communicate with other layers

```bash
src
├── Application
│   ├── Modules
│   └── Provider
├── Core
│   ├── Utils
│   ├── Hepler
├── Domain
│   ├── Model
├── Http
│   ├── Bundle
│   ├── CompilerPass
│   ├── Controller
│   ├── Exception
│   ├── Middleware
├── Infrastructure
│   ├── Fixtures
│   ├── Migrations
│   ├── Repository
```

To see more about DDD : [click here](https://airbrake.io/blog/software-design/domain-driven-design).

### Command Query Responsibility Segregation

I also use the **CQRS** pattern **(Command Query Responsibility Segregation)** which allows the separation, within an application, of the components of business information processing ("command" / writing) and information retrieval ("query" / reading).

You can therefore put the verbs **"POST"**, **"PUT"**, **"PATCH"** and **"DELETE"** on the commands side and the verb **"GET"** on the queries side.

For example, in this api, you have request on users, so in the Application layer who have this architecture :
```bash
Application
├── Modules
│   ├── User
│   │   ├── Command
│   │   │   ├── CreateUser
│   │   │   ├── DeleteUser
│   │   │   ├── UpdateUser
│   │   ├── Query
│   │   │   ├── GetUser
│   │   │   ├── GetUsers
```

### Abstraction and implementation

The vast majority of API classes, and more often when they fall into class categories (Command, Query, Entity, Repository, etc...) inherit from an abstract class or interface. This method complies with the **SOLID** principle. 

Adhering to this principle gives the advantage of a reusable, easily malleable code and allows typing to be carried out correctly on a wide range of classes.

### ParamConverter

Symfony allow to directly transform parameters of a request to an object.

But it also possible to create his own **ParamConverter**, that's what was done in the layer (Http/Middleware/ParamConverter) with classes **RouteParamConverter** and **BodyParamConverter**. 

The RouteParamConverter is used generally for query with params in the path and query of the request whereas the BodyParamConverter is used for for the Command, when you need to persist an entity.

```php
<?php

namespace App\Http\Controller\User;

class UserController
{
    /**
     * @param GetUserQuery $query
     * @return Response
     *
     * @ParamConverter(name="query", class=GetUserQuery::class, converter="http.route")
     *
     * @Route("/users/{id<^[1-9]\d*$>}", name="get_user", methods={"GET"})
     */
    public function getUser(GetUserQuery $query): Response
    {
        /** @var GetUserQueryResponse $response */
        $response = $this->bus->dispatch($query);

        if (empty($response->getUser())) return $this->noContent();
        return $this->ok($response);
    }
    
    /**
     * @param CreateUserCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=CreateUserCommand::class, converter="http.body")
     *
     * @Route("/users", name="create_user", methods={"POST"})
     */
    public function createUser(CreateUserCommand $command): Response
    {
        /** @var IdentifierCommandResponse $response */
        $response = $this->bus->dispatch($command);

        return $this->created($response);
    }
}
```

More about params converters in the [symfony documentation](https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html).

### AutoMapper

In order to map our orders to entities and our entities to **DTOs** (Data Transfer Object), an automatic mapping has been implemented.
To use it, mapping profiles must be set up in the various aggregate directories of the entity groups and master groups of the application layer.
The mapping of identical names is done automatically, the rest can be generated via the "forMember" function.

```php
<?php

namespace App\Application\Modules\User\Query\GetUsers;

class GetUsersMappingProfile
{
    /**
     * Mapping configuration
     */
    protected function initialize(): void
    {
        $this->config->registerMapping(User::class, UserDto::class)
            ->forMember("countryCodeValue", function (User $user) {
                return $this->referenceAccessor->getReference("country-code", $user->getCountryCode());
            });
    }
}
```

To have more details, see the [AutoMapperPlus documentation](https://github.com/mark-gerarts/automapper-plus) on github.

### NelmioApiDocBundle

In order to generate the API documentation automatically, we use [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle). 
This bundle allows the developer to set up the documentation of his functions via annotations in the method of his Controller. Annotations work with [Swagger](https://swagger.io).

## TODO List

- [x] Add phpunit tests
- [ ] Authentication via Jwt (getContext)
- [ ] Add Domain Event