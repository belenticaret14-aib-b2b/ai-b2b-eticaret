codeunit 50001 "Merhaba Test"
{
    Subtype = Test;

    [Test]
    procedure TestGetGreeting()
    var
        MerhabaCodeunit: Codeunit "Merhaba Codeunit";
        ExpectedGreeting: Text;
        ActualGreeting: Text;
    begin
        // [GIVEN] Expected greeting message
        ExpectedGreeting := 'Merhaba! Hello from Dynamics 365 Business Central!';

        // [WHEN] Getting greeting from codeunit
        ActualGreeting := MerhabaCodeunit.GetGreeting();

        // [THEN] Greeting should match expected value
        if ActualGreeting <> ExpectedGreeting then
            Error('Expected: %1, but got: %2', ExpectedGreeting, ActualGreeting);
    end;

    [Test]
    procedure TestGetGreetingInTurkish()
    var
        MerhabaCodeunit: Codeunit "Merhaba Codeunit";
        ExpectedGreeting: Text;
        ActualGreeting: Text;
    begin
        // [GIVEN] Expected Turkish greeting message
        ExpectedGreeting := 'Merhaba! Dynamics 365 Business Central''dan selamlar!';

        // [WHEN] Getting Turkish greeting from codeunit
        ActualGreeting := MerhabaCodeunit.GetGreetingInTurkish();

        // [THEN] Greeting should match expected value
        if ActualGreeting <> ExpectedGreeting then
            Error('Expected: %1, but got: %2', ExpectedGreeting, ActualGreeting);
    end;

    [Test]
    procedure TestGreetingNotEmpty()
    var
        MerhabaCodeunit: Codeunit "Merhaba Codeunit";
        ActualGreeting: Text;
    begin
        // [WHEN] Getting greeting from codeunit
        ActualGreeting := MerhabaCodeunit.GetGreeting();

        // [THEN] Greeting should not be empty
        if ActualGreeting = '' then
            Error('Greeting should not be empty');
    end;
}
