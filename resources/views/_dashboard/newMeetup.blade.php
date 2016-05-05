<form name="newMeetupForm" novalidate ng-submit="createNewMeetup()">
    <div layout="row" layout-align="center center">
        <h3 class="md-title">
            Create a new Meetup
        </h3>
    </div>
    <div layout="row" layout-margin>
        <md-checkbox ng-model="meetup.online" aria-label="Online Meetup">
            Online Meetup
        </md-checkbox>
        <md-input-container flex>
            <label>Start Time (double click choices)</label>
            <input type="text"
                   mdc-datetime-picker
                   required
                   date="true"
                   time="true"
                   id="startTime"
                   name="startTime"
                   format="MM/DD/YYYY h:mma"
                   ng-model="meetup.start_time" />
            <ng-messages for="newMeetupForm.startTime.$error">
                <ng-message with="required">Start time is required</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container class="md-input-has-placeholder" flex ng-hide="meetup.online">
            <label>Location</label>
            <input type="text"
                   ng-autocomplete
                   ng-required="!meetup.online"
                   id="locationName"
                   name="locationName"
                   details="placeDetails"
                   ng-model="meetup.location_name" />
            <ng-messages for="newMeetupForm.locationName.$error">
                <ng-message with="required">A place is required</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin ng-hide="meetup.online">
        <md-input-container flex>
            <label>Location Address</label>
            <input type="text"
                   ng-required="!meetup.online"
                   name="locationAddress"
                   id="locationAddress"
                   ng-model="meetup.location_address" />
            <ng-messages for="newMeetupForm.locationAddress.$error">
                <ng-message with="required">An address is required</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin ng-hide="meetup.online">
        <md-input-container flex="50">
            <label>Location Phone</label>
            <input type="text"
                   ng-required="!meetup.online"
                   id="locationPhone"
                   name="locationPhone"
                   ng-model="meetup.location_phone" />
            <ng-messages for="newMeetupForm.locationPhone.$error">
                <ng-message with="required">A phone number is required</ng-message>
            </ng-messages>
        </md-input-container>
        <md-input-container flex="50">
            <label>Location Url</label>
            <input type="url"
                   ng-required="!meetup.online"
                   id="locationUrl"
                   name="locationUrl"
                   ng-model="meetup.location_url" />
            <ng-messages for="newMeetupForm.locationUrl.$error">
                <ng-message with="required">A phone number is required</ng-message>
                <ng-message with="url">Not a valid url</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container flex>
            <label>Talk (or dinner headline)</label>
            <input type="text"
                   required
                   id="meetupTalk"
                   name="meetupTalk"
                   maxlength="255"
                   ng-model="meetup.talk" />
            <ng-messages for="newMeetupForm.meetupTalk.$error">
                <ng-message with="required">A talk or dinner headline is required</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <div flex="10" ng-show="newMeetupForm.speakerImgUrl.$valid">
            <img ng-src="@{{ meetup.speaker_img }}"
                 width="60"
                 height="60" />
        </div>
        <md-input-container flex="30">
            <label>Speaker's Name</label>
            <input type="text"
                   name="speakerName"
                   id="speakerName"
                   ng-model="meetup.speaker" />
        </md-input-container>
        <md-input-container flex="30">
            <label>Speaker's Image Url</label>
            <input type="url"
                   name="speakerImgUrl"
                   id="speakerImgUrl"
                   ng-model="meetup.speaker_img" />
            <ng-messages for="newMeetupForm.speakerImgUrl.$error">
                <ng-message with="url">Not a valid url</ng-message>
            </ng-messages>
        </md-input-container>
        <md-input-container flex="30">
            <label>Speaker's Contact Url</label>
            <input type="url"
                   name="speakerUrl"
                   id="speakerUrl"
                   ng-model="meetup.speaker_url" />
            <ng-messages for="newMeetupForm.speakerUrl.$error">
                <ng-message with="url">Not a valid url</ng-message>
            </ng-messages>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container flex>
            <label>Additional Info</label>
            <input type="text"
                   ng-model="meetup.additional_info" />
        </md-input-container>
    </div>
    <div layout="row" layout-align="center center">
        <md-button class="md-raised md-primary" type="submit" ng-disabled="savingNewMeetup || newMeetupForm.$invalid">
            Save New Meetup
        </md-button>
    </div>
</form>