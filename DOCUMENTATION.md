# PROJECT DOCUMENTATION - methods and some logics are documented in the code itself

SoccerSwap - is a symfony project where individual/business create team of players and later buy or sell.

# TOOLS, STACKS USED

1. Visual Studio Code
2. Xampp
3. SQLyog

# LANGUAGES, FRAMEWORKS ETC

1. PHP (Version: 8.1.12)
2. SYMFONY FRAMEWORK (Version 6.2.10)
3. COMPOSER (version 2.5.5)


# DESIGN PATTENS

1. DEPENDENCY INJECTION
This strategy was used because most repository is needed across the classes, i.e., in multiple methods, 
and would be better to inject it via constructors. This ensures that the repository instance is available to all
methods in the class and reduces code duplication. 
Additionally, it makes the code easier to read and maintain as it 
explicitly states the dependencies of the class in the constructor.
Was used in Controllers, other classes etc
2. IOC



# ENTITY CREATED
1. Country
2. Team
3. Player
4. SellPlayer
5. BuyPlayer(No longer in use)

# REPOSITORY 

1. CountryRepository
2. TeamRepository
3. PlayerRepository
4. SellPlayerRepository
 

# CONTROLLERS

1. HOMECONTROLLER
2. PLAYERCONTROLLER
3. TEAMCONTROLLER

# FORM

1. AddTeamType
2. AddPlayerType
3. AddSellPlayerType
4. AddBuyPlayerType (No longer in use)

# Rules

1. UniqueEntry
2. UniqueEntryValidator

# TEMPLATES

1. home/index
2. player
   i. add
   ii. index
   iii. show
3. team
    i. add
    ii. index
    iii. transaction

