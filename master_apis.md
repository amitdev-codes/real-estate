1. Agents & listings

Get/v1/agencies
Get/v1/agencies/{id}
Get/v1/agencies/{id}/listings
Get/v1/agents/{id}
Get/v1/agents/{id}/listings
Get/v1/agents/search
Get/v1/listings/id
Get/v1/listings/locations
Get/v1/me
Get/v1/me/agencies
Get/v1/projects
Get/v1/projects/{id}
Get/v1/projects/{id}/listings

Head/v1/agencies
Post/v1/agencies
Post/v1/listings/business/_search
Post/v1/listings/commercial/_search
Post/v1/listings/residential/_search
Post/v1/listings/statistics/{event}

2.Property radar

DELETE /v1/propertyradar/portfolio/{PortfolioId}	
GET /v1/propertyradar/portfolio/{PortfolioId}	
GET /v1/propertyradar/portfolio/{PortfolioId}/properties	
GET /v1/propertyradar/portfolio/{PortfolioId}/properties/{PropertyId}	
GET /v1/propertyradar/portfoliosummary	
POST /v1/propertyradar/portfolio	
POST /v1/propertyradar/portfolio/{PortfolioId}	
POST /v1/propertyradar/portfolio/{PortfolioId}/property/delete	

3.schools data
GET /v2/schools/{id}	
GET /v2/schools/{latitude}/{longitude}	

4. property package

Endpoint	Description
GET /v1/addressLocators	Retrieves matching ids for use in other services.
GET /v1/locations/profiles/{domainLocationId}	Get location data based on the given domainLocationId
GET /v1/projects	Searches projects
GET /v1/projects/{id}	Details of project
GET /v1/projects/{id}/listings	Project listings
GET /v1/properties/_suggest	Search for suggested addresses for the given terms
GET /v1/properties/{id}	Retrieves a specific property.
GET /v1/properties/{propertyId}/priceEstimate	Price estimates based on propertyId
GET /v2/demographics/{state}/{suburb}	Search for demographics in a given geographic level.
GET /v2/demographics/{state}/{suburb}/{postcode}	Search for demographics in a given geographic level.
GET /v2/schools/{latitude}/{longitude}	Search for a school in a location
GET /v2/suburbPerformanceStatistics/{state}/{suburb}	Search for sales statistics in a given geographic level.
GET /v2/suburbPerformanceStatistics/{state}/{suburb}/{postcode}	Search for sales statistics in a given geographic level.
POST /v1/listings/residential/_search

5.property enrichment

GET /v1/propertyenrichment	API that supplies property level data and activities across two packages for a specific property

6.properties and locations

GET /v1/addressLocators	Retrieves matching ids for use in other services.
GET /v1/disclaimers	Retrieves disclaimers for given ids
GET /v1/disclaimers/product/{product}	Retrieves disclaimers for given product
GET /v1/locations/profiles/{domainLocationId}	Get location data based on the given domainLocationId
GET /v1/properties/{id}	Retrieves a specific property.
GET /v1/salesResults/_head	Retrieves metadata regarding sales result data
GET /v1/salesResults/{city}	Retrieves sales results for a given city
GET /v1/salesResults/{city}/listings	Retrieves listing summaries corresponding to the sales results
GET /v2/demographics/{state}/{suburb}	Search for demographics in a given geographic level.
GET /v2/demographics/{state}/{suburb}/{postcode}	Search for demographics in a given geographic level.
GET /v2/suburbPerformanceStatistics/{state}/{suburb}	Search for sales statistics in a given geographic level.
GET /v2/suburbPerformanceStatistics/{state}/{suburb}/{postcode}	Search for sales statistics in a given geographic level.

7.price estimation

GET /v1/properties/{propertyId}/priceEstimate	Price estimates based on propertyId

8.Listings management

GET /v1/agencies/{id}/listings	Retrieves listings across all channels for a specific agency matching specified criteria.
GET /v1/agencies/{id}/statistics	Retrieves statistics for a specific agency.
GET /v1/agents/{id}/statistics	Retrieves stats for the listings of a given agent
GET /v1/enquiries	Searches enquiries based on agents or agencies.
GET /v1/enquiries/{id}	Retrieve the details of a specific enquiry
GET /v1/listings/{id}	Retrieve details of listing using the listing id
GET /v1/listings/{id}/enquiries	Retrieve details of all enquiries received for a specific listing
GET /v1/listings/{id}/statistics	Retrieve details of listing using the listing id
GET /v1/listings/processingReports	Searches processing reports
GET /v1/listings/processingReports/{id}	Gets the processing report
GET /v1/me	Retrieve information about the currently authorised request
GET /v1/me/agencies	Retrieve list of agencies with which the current client is associated
GET /v1/me/providers	Retrieve list of provider Ids with which the current client is associated
GET /v1/projects	Searches projects
GET /v1/projects/{id}	Details of project
GET /v1/projects/{id}/enquiries	Retrieve details of all enquiries received for a specific new development project
GET /v1/projects/{id}/listings	Project listings
GET /v1/projects/{id}/listings/statistics	Retrieves statistics for a specific project with a breakdown for listings.
GET /v1/projects/{id}/statistics	Retrieves statistics for a specific project.
POST /v1/agencies/_testAgency	Create a test agency for sandbox testing
POST /v1/enquiries	Sends an enquiry for listing, agency, etc... (based on the enquiry type and referenceid).
POST /v2/listings/business/offmarket	Creates an externally sold business listing; or takes an existing business listing off the market.
POST /v2/listings/commercial/offmarket	Creates an externally sold or leased commercial listing; or takes an existing commercial listing off the market.
POST /v2/listings/residential/offmarket	Creates an externally sold or leased residential listing; or takes an existing residential listing off the market.
PUT /v1/listings/business	Creates or updates a business listing
PUT /v1/listings/residential	Creates or updates a residential listing
PUT /v2/listings/commercial	Creates a commercial listing.

9.Address suggestions

GET /v1/properties/_suggest
